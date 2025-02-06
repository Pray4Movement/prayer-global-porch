<?php
declare(strict_types=1);

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly


require_once( 'abstract.php' );

/**
 * Class Disciple_Tools_Migration_0000
 */
class Prayer_Global_Migration_0005 extends Prayer_Global_Migration {

    /**
     * @throws \Exception  Got error when creating table $name.
     */
    public function up() {
        global $wpdb;
        $wpdb->posts = $wpdb->prefix . 'posts';
        $wpdb->postmeta = $wpdb->prefix . 'postmeta';
        $wpdb->p2p = $wpdb->prefix . 'p2p';
        $wpdb->dt_reports = $wpdb->prefix . 'dt_reports';

        $wpdb->query( "
            DROP PROCEDURE IF EXISTS update_reports_with_relay_ids;
        " );
        /* Loop over relays and update all reports and lap children with these post ids */
        $wpdb->query( "
            CREATE PROCEDURE update_reports_with_relay_ids()
            BEGIN
                DECLARE done INT DEFAULT FALSE;
                DECLARE lap_id INT;
                DECLARE cursorLaps CURSOR FOR
                    SELECT ID
                        FROM $wpdb->posts
                    WHERE
                        post_type = 'pg_relays';
                DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

                OPEN cursorLaps;

                read_loop: LOOP
                    FETCH cursorLaps INTO lap_id;
                    IF done THEN
                        LEAVE read_loop;
                    END IF;

                    CALL update_reports_with_id(lap_id);

                END LOOP read_loop;

                CLOSE cursorLaps;
            END;
        " );
        $wpdb->query( "
            DROP PROCEDURE IF EXISTS update_reports_with_id;
        " );
        $wpdb->query( "
            CREATE PROCEDURE update_reports_with_id(id INT)
            BEGIN
                DECLARE done INT DEFAULT FALSE;
                DECLARE lap_id INT;
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

                OPEN cursorLaps;

                UPDATE $wpdb->dt_reports
                SET post_type = 'pg_relays'
                WHERE post_id = id;

                read_loop: LOOP
                    FETCH cursorLaps INTO lap_id;
                    IF done THEN
                        LEAVE read_loop;
                    END IF;

                    UPDATE $wpdb->dt_reports
                    SET post_id = id, post_type = 'pg_relays'
                    WHERE post_id = lap_id;

                END LOOP read_loop;

                CLOSE cursorLaps;
            END;
        " );
        $wpdb->query( "
            CALL update_reports_with_relay_ids();
        " );
    }

    /**
     * @throws \Exception  Got error when dropping table $name.
     */
    public function down() {}

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
