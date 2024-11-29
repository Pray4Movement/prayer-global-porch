DROP TABLE IF EXISTS wp_dt_relays;
CREATE TABLE wp_dt_relays (
    id BIGINT(20) NOT NULL AUTO_INCREMENT,
    relay_id VARCHAR(20) NOT NULL,
    grid_id BIGINT(20) NOT NULL,
	total INT DEFAULT 0,
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

    CALL update_relay_with_id( id, relay_key );

    OPEN cursorLaps;

    read_loop: LOOP
        FETCH cursorLaps INTO lap_id;
        IF done THEN
            LEAVE read_loop;
        END IF;

        CALL update_relay_with_id( lap_id, relay_key );
    END LOOP read_loop;

    CLOSE cursorLaps;
END//
delimiter ;

delimiter //
DROP PROCEDURE IF EXISTS update_relay_with_id//
CREATE PROCEDURE update_relay_with_id(lap_id INT, relay_id VARCHAR(20))
BEGIN
    INSERT INTO wp_postmeta (post_id, meta_key, meta_value)
    VALUES ( lap_id, 'prayer_app_relay_key', relay_id );
END//

CALL update_all_relays_with_relay_key('global')
CALL update_all_relays_with_relay_key('custom')

delimiter ;

## Aggregate the counts of grid_ids and relay_ids into the wp_dt_relays table

INSERT INTO ( grid_id, relay_id, total )
SELECT r.grid_id, pm.meta_value as relay_id, COUNT(*) AS total FROM wp_dt_reports r
JOIN wp_postmeta pm ON r.post_id = pm.post_id
WHERE pm.meta_key = 'prayer_app_relay_key'
GROUP BY pm.meta_value, r.grid_id
ORDER BY pm.meta_value