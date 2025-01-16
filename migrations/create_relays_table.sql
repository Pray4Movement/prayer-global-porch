DROP TABLE IF EXISTS wp_dt_relays;
CREATE TABLE wp_dt_relays (
    id BIGINT(20) NOT NULL AUTO_INCREMENT,
    relay_id VARCHAR(20) NOT NULL,
    grid_id BIGINT(20) NOT NULL,
	total INT DEFAULT 0,
	timestamp INT DEFAULT NOW(),
    PRIMARY KEY (id)
);

## Give the same relay_id to all parent and child laps of a relay

### Get all the current active laps and update their relays with the same keys
delimiter //
DROP PROCEDURE IF EXISTS update_all_relays_with_relay_key//
CREATE PROCEDURE update_all_relays_with_relay_key( lap_type VARCHAR(20) )
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE lap_id INT;
    DECLARE cursorActiveLaps CURSOR FOR
        SELECT ID from wp_posts
            JOIN wp_postmeta p ON ID = p.post_id AND p.meta_key = 'status' AND p.meta_value = 'active'
            JOIN wp_postmeta p1 ON ID = p1.post_id AND p1.meta_key = 'type' AND p1.meta_value = lap_type;
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
END//

delimiter //
### Get the ancestor laps from the active lap
DROP PROCEDURE IF EXISTS update_relay_with_relay_key//
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
            SELECT p2p_from, p2p_to FROM wp_p2p WHERE p2p_to = id AND p2p_type = 'parent-lap_to_child-lap'
            UNION ALL
            ## output the next link in the chain
            SELECT _next.p2p_from, _next.p2p_to
            FROM cte _current
            JOIN wp_p2p _next
            ## link up the chain to the parent
            ON _current.p2p_from_ = _next.p2p_to
            AND _next.p2p_type = 'parent-lap_to_child-lap'
        )
        SELECT c.p2p_from_
        FROM cte c;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    SELECT meta_value INTO relay_key
    FROM wp_postmeta
    WHERE post_id = id
    AND meta_key = CONCAT('prayer_app_', lap_type ,'_magic_key');

    SELECT meta_value INTO start_time
    FROM wp_postmeta
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
    END LOOP read_loop;

    CLOSE cursorLaps;

    # Make sure that the active lap has the correct lap number
    IF (SELECT meta_value FROM wp_postmeta WHERE meta_key = 'global_lap_number' AND post_id = id) IS NULL THEN
        INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
        VALUES ( id, 'global_lap_number', lap_number + 1 );
    ELSE
        UPDATE wp_postmeta
        SET meta_value = lap_number + 1
        WHERE meta_key = 'global_lap_number'
        AND post_id = id;
    END IF;

    CALL populate_relay_table_with_data( relay_key, lap_number, start_time );
END//
delimiter ;

delimiter //
DROP PROCEDURE IF EXISTS update_relay_with_id//
CREATE PROCEDURE update_relay_with_id(lap_id INT, relay_id VARCHAR(20))
BEGIN
    INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
    VALUES ( lap_id, 'prayer_app_relay_key', relay_id );
END//

delimiter ;

delimiter //
DROP PROCEDURE IF EXISTS populate_relay_table_with_data//
CREATE PROCEDURE populate_relay_table_with_data(relay_key VARCHAR(20), lap_number INT, start_time VARCHAR(20))
BEGIN
    # Get all grid_ids into the relays table with a total of the number of completed laps so far
    INSERT INTO wp_dt_relays ( relay_id, grid_id, total )
    SELECT relay_key as relay_id, r.grid_id, lap_number as total FROM wp_dt_reports r
    JOIN wp_postmeta pm ON r.post_id = pm.post_id
    WHERE pm.meta_key = 'prayer_app_relay_key'
    AND pm.meta_value = '49ba4c'
    GROUP BY r.grid_id;

    IF relay_key = '49ba4c' THEN
        UPDATE wp_dt_relays l
        JOIN (
            SELECT relay_key as relay_id, r.grid_id, lap_number as total FROM wp_dt_reports r
            WHERE r.timestamp > start_time
            GROUP BY r.grid_id
        ) c
        ON l.relay_id = c.relay_id AND l.grid_id = c.grid_id
        SET l.total = lap_number + 1;
    ELSE

        # For every unique grid_id in reports table since the start of current global lap, increment total in relay
        UPDATE wp_dt_relays l
        JOIN (
            SELECT relay_key as relay_id, r.grid_id, lap_number as total FROM wp_dt_reports r
            JOIN wp_postmeta pm ON r.post_id = pm.post_id
            WHERE pm.meta_key = 'prayer_app_relay_key'
            AND pm.meta_value = relay_key
            AND r.timestamp > start_time
            GROUP BY r.grid_id
        ) c
        ON l.relay_id = c.relay_id AND l.grid_id = c.grid_id
        SET l.total = lap_number + 1;

    END IF;

END//

delimiter ;

CALL update_all_relays_with_relay_key('global');
CALL update_all_relays_with_relay_key('custom');


