<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0002 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';
        $wpdb->dt_relays = $wpdb->prefix . 'dt_relays';
        $wpdb->posts = $wpdb->prefix . 'posts';
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';
        $wpdb->p2p = $wpdb->prefix . 'p2p';

        /* Add relay_key to all ancestor laps, using the youngest in a chain's lap key as the relay key */
        /* Add correct global_lap_number to all ancestor laps */
        /* populate the relays table using the latest lap number and reports table to create a lap_number... lap_number-1... structure */


        $wpdb->query( '
            DROP PROCEDURE IF EXISTS update_all_relays_with_relay_key;
        ' );
        $wpdb->query( "
            CREATE PROCEDURE update_all_relays_with_relay_key( lap_type VARCHAR(20) )
            BEGIN
                DECLARE done INT DEFAULT FALSE;
                DECLARE lap_id INT;
                DECLARE cursorActiveLaps CURSOR FOR
                    SELECT ID from $wpdb->posts
                        JOIN $wpdb->postmeta p1 ON ID = p1.post_id AND p1.meta_key = 'type' AND p1.meta_value = lap_type
                        LEFT JOIN $wpdb->p2p pp ON p2p_from = ID
                        WHERE post_type = 'laps'
                        AND p2p_from IS NULL;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

                OPEN cursorActiveLaps;

                read_loop: LOOP
                    FETCH cursorActiveLaps INTO lap_id;
                    IF done THEN
                        LEAVE read_loop;
                    END IF;

                    CALL update_relay_with_relay_key( lap_id, lap_type );
                END LOOP read_loop;

                CLOSE cursorActiveLaps;
            END
        " );
        $wpdb->query( '
            DROP PROCEDURE IF EXISTS update_relay_with_relay_key;
        ' );
        $wpdb->query( "
            ### Get the ancestor laps from the active lap
            CREATE PROCEDURE update_relay_with_relay_key(id INT, lap_type VARCHAR(20))
            BEGIN
                DECLARE done INT DEFAULT FALSE;
                DECLARE lap_id INT;
                DECLARE relay_key VARCHAR(20);
                DECLARE lap_number INT;
                DECLARE start_time VARCHAR(20);
                DECLARE cursorLaps CURSOR FOR
                    WITH RECURSIVE cte ( p2p_from_, p2p_to_ ) AS (
                        ## where p2p_to = %d is looking at the last child in the chain
                        SELECT p2p_from, p2p_to FROM $wpdb->p2p WHERE p2p_to = id AND p2p_type = 'parent-lap_to_child-lap'
                        UNION ALL
                        ## output the next link in the chain
                        SELECT _next.p2p_from, _next.p2p_to
                        FROM cte _current
                        JOIN $wpdb->p2p _next
                        ## link up the chain to the parent
                        ON _current.p2p_from_ = _next.p2p_to
                        AND _next.p2p_type = 'parent-lap_to_child-lap'
                    )
                    SELECT c.p2p_from_
                    FROM cte c
                    ORDER BY c.p2p_from_ ASC;
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

                SELECT meta_value INTO relay_key
                FROM $wpdb->postmeta
                WHERE post_id = id
                AND meta_key = CONCAT('prayer_app_', lap_type ,'_magic_key');

                SELECT meta_value INTO start_time
                FROM $wpdb->postmeta
                WHERE post_id = id
                AND meta_key = 'start_time';

                CALL update_relay_with_id( id, relay_key );

                SET lap_number = 0;

                OPEN cursorLaps;

                read_loop: LOOP
                    FETCH cursorLaps INTO lap_id;
                    IF done THEN
                        LEAVE read_loop;
                    END IF;

                    SET lap_number = lap_number + 1;
                    CALL update_relay_with_id( lap_id, relay_key );

                    # Make sure that the active lap has the correct lap number
                    IF (SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'global_lap_number' AND post_id = lap_id) IS NULL THEN
                        INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value)
                        VALUES ( lap_id, 'global_lap_number', lap_number );
                    ELSE
                        UPDATE $wpdb->postmeta
                        SET meta_value = lap_number
                        WHERE meta_key = 'global_lap_number'
                        AND post_id = lap_id;
                    END IF;

                END LOOP read_loop;

                # Make sure that the active lap has the correct lap number
                IF (SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = 'global_lap_number' AND post_id = id) IS NULL THEN
                    INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value)
                    VALUES ( id, 'global_lap_number', lap_number + 1 );
                ELSE
                    UPDATE $wpdb->postmeta
                    SET meta_value = lap_number + 1
                    WHERE meta_key = 'global_lap_number'
                    AND post_id = id;
                END IF;

                CLOSE cursorLaps;

                CALL populate_relay_table_with_data( relay_key, lap_number, start_time );
            END
        " );
        $wpdb->query( '
            DROP PROCEDURE IF EXISTS update_relay_with_id;
        ' );
        $wpdb->query( "
            CREATE PROCEDURE update_relay_with_id(lap_id INT, relay_id VARCHAR(20))
            BEGIN
                INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value)
                VALUES ( lap_id, 'prayer_app_relay_key', relay_id );
            END
        " );
        $wpdb->query( '
            DROP PROCEDURE IF EXISTS populate_relay_table_with_data;
        ' );
        $wpdb->query( "
            CREATE PROCEDURE populate_relay_table_with_data(relay_key VARCHAR(20), lap_number INT, start_time VARCHAR(20))
            BEGIN
                # Get all grid_ids into the relays table with a total of the number of completed laps so far
                INSERT INTO $wpdb->dt_relays ( relay_id, grid_id, total, epoch )
                SELECT relay_key as relay_id, r.grid_id, lap_number as total, FLOOR(RAND() * 1001) as epoch FROM $wpdb->dt_reports r
                JOIN $wpdb->postmeta pm ON r.post_id = pm.post_id
                WHERE pm.meta_key = 'prayer_app_relay_key'
                AND pm.meta_value = '49ba4c'
                GROUP BY r.grid_id;

                IF relay_key = '49ba4c' THEN
                    UPDATE $wpdb->dt_relays l
                    JOIN (
                        SELECT relay_key as relay_id, r.grid_id, lap_number as total FROM $wpdb->dt_reports r
                        WHERE r.timestamp > start_time
                        GROUP BY r.grid_id
                    ) c
                    ON l.relay_id = c.relay_id AND l.grid_id = c.grid_id
                    SET l.total = lap_number + 1;
                ELSE

                    # For every unique grid_id in reports table since the start of current global lap, increment total in relay
                    UPDATE $wpdb->dt_relays l
                    JOIN (
                        SELECT relay_key as relay_id, r.grid_id, lap_number as total FROM $wpdb->dt_reports r
                        JOIN $wpdb->postmeta pm ON r.post_id = pm.post_id
                        WHERE pm.meta_key = 'prayer_app_relay_key'
                        AND pm.meta_value = relay_key
                        AND r.timestamp > start_time
                        GROUP BY r.grid_id
                    ) c
                    ON l.relay_id = c.relay_id AND l.grid_id = c.grid_id
                    SET l.total = lap_number + 1;

                END IF;

            END;
        " );
        $wpdb->query( "
            CALL update_all_relays_with_relay_key('global');
        " );
        $wpdb->query( "
            CALL update_all_relays_with_relay_key('custom');
        " );
        //phpcs:enable
    }

    /**
     * @throws \Exception  Got error when dropping table $name.
     */
    public function down() {
        global $wpdb;
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';
        $wpdb->query( "
            ALTER TABLE $wpdb->dt_reports
            REMOVE COLUMN lap_number
        " );
    }

    /**
     * @return array
     */
    public function get_expected_tables(): array {
        return [];
    }

    /**
     * Test function
     */
    public function test() {
        $this->test_expected_tables();
    }
}
