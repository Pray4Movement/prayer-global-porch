<?php
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly.

class Prayer_Global_Porch_Map_Queries {
    /**
     * This query returns the 50k saturation list of locations with population and country code.
     *
     * Returns
     * grid_id, population, country_code
     *
     * @return array
     */
    public static function query_saturation_list() : array {

        if ( false !== ( $value = get_transient( __METHOD__ ) ) ) { // phpcs:ignore
            return $value;
        }

        // 44141 records

        global $wpdb;
        $results = $wpdb->get_results("

            SELECT
            lg1.grid_id, lg1.population, lg1.country_code
            FROM $wpdb->dt_location_grid lg1
            WHERE lg1.level = 0
			AND lg1.grid_id NOT IN ( SELECT lg11.admin0_grid_id FROM $wpdb->dt_location_grid lg11 WHERE lg11.level = 1 AND lg11.admin0_grid_id = lg1.grid_id )
 			#'China', 'India', 'France', 'Spain', 'Pakistan', 'Bangladesh'
            AND lg1.admin0_grid_id NOT IN (100050711,100219347, 100089589,100074576,100259978,100018514)
            #'Romania', 'Estonia', 'Bhutan', 'Croatia', 'Solomon Islands', 'Guyana', 'Iceland', 'Vanuatu', 'Cape Verde', 'Samoa', 'Faroe Islands', 'Norway', 'Uruguay', 'Mongolia', 'United Arab Emirates', 'Slovenia', 'Bulgaria', 'Honduras', 'Columbia', 'Namibia', 'Switzerland', 'Western Sahara'
            AND lg1.admin0_grid_id NOT IN (100314737,100083318,100041128,100133112,100341242,100132648,100222839,100379914,100055707,100379993,100130389,100255271,100363975,100248845,100001527,100342458,100024289,100132795,100054605,100253456,100342975,100074571)
			# above admin 0 (22)

			UNION ALL
            --
            # admin 1 for countries that have no level 2 (768)
            --
            SELECT
            lg2.grid_id, lg2.population, lg2.country_code
            FROM $wpdb->dt_location_grid lg2
            WHERE lg2.level = 1
			AND lg2.grid_id NOT IN ( SELECT lg22.admin1_grid_id FROM $wpdb->dt_location_grid lg22 WHERE lg22.level = 2 AND lg22.admin1_grid_id = lg2.grid_id )
             #'China', 'India', 'France', 'Spain', 'Pakistan', 'Bangladesh'
            AND lg2.admin0_grid_id NOT IN (100050711,100219347, 100089589,100074576,100259978,100018514)
            #'Romania', 'Estonia', 'Bhutan', 'Croatia', 'Solomon Islands', 'Guyana', 'Iceland', 'Vanuatu', 'Cape Verde', 'Samoa', 'Faroe Islands', 'Norway', 'Uruguay', 'Mongolia', 'United Arab Emirates', 'Slovenia', 'Bulgaria', 'Honduras', 'Columbia', 'Namibia', 'Switzerland', 'Western Sahara'
            AND lg2.admin0_grid_id NOT IN (100314737,100083318,100041128,100133112,100341242,100132648,100222839,100379914,100055707,100379993,100130389,100255271,100363975,100248845,100001527,100342458,100024289,100132795,100054605,100253456,100342975,100074571)

			UNION ALL
			--
            # admin 2 all countries (37100)
            --
			SELECT
            lg3.grid_id, lg3.population,  lg3.country_code
            FROM $wpdb->dt_location_grid lg3
            WHERE lg3.level = 2
            #'China', 'India', 'France', 'Spain', 'Pakistan', 'Bangladesh'
            AND lg3.admin0_grid_id NOT IN (100050711,100219347, 100089589,100074576,100259978,100018514)
            #'Romania', 'Estonia', 'Bhutan', 'Croatia', 'Solomon Islands', 'Guyana', 'Iceland', 'Vanuatu', 'Cape Verde', 'Samoa', 'Faroe Islands', 'Norway', 'Uruguay', 'Mongolia', 'United Arab Emirates', 'Slovenia', 'Bulgaria', 'Honduras', 'Columbia', 'Namibia', 'Switzerland', 'Western Sahara'
            AND lg3.admin0_grid_id NOT IN (100314737,100083318,100041128,100133112,100341242,100132648,100222839,100379914,100055707,100379993,100130389,100255271,100363975,100248845,100001527,100342458,100024289,100132795,100054605,100253456,100342975,100074571)

			UNION ALL
            --
            # admin 1 for little highly divided countries (352)
            --
            SELECT
            lg4.grid_id, lg4.population,  lg4.country_code
            FROM $wpdb->dt_location_grid lg4
            WHERE lg4.level = 1
            #'China', 'India', 'France', 'Spain', 'Pakistan', 'Bangladesh'
            AND lg4.admin0_grid_id NOT IN (100050711,100219347, 100089589,100074576,100259978,100018514)
            #'Romania', 'Estonia', 'Bhutan', 'Croatia', 'Solomon Islands', 'Guyana', 'Iceland', 'Vanuatu', 'Cape Verde', 'Samoa', 'Faroe Islands', 'Norway', 'Uruguay', 'Mongolia', 'United Arab Emirates', 'Slovenia', 'Bulgaria', 'Honduras', 'Columbia', 'Namibia', 'Switzerland', 'Western Sahara'
            AND lg4.admin0_grid_id IN (100314737,100083318,100041128,100133112,100341242,100132648,100222839,100379914,100055707,100379993,100130389,100255271,100363975,100248845,100001527,100342458,100024289,100132795,100054605,100253456,100342975,100074571)

			UNION ALL

 			--
            # admin 3 for big countries (6153)
            --
            SELECT
            lg5.grid_id, lg5.population, lg5.country_code
            FROM $wpdb->dt_location_grid as lg5
            WHERE
            lg5.level = 3
            #'China', 'India', 'France', 'Spain', 'Pakistan', 'Bangladesh'
            AND lg5.admin0_grid_id IN (100050711,100219347, 100089589,100074576,100259978,100018514)
            #'Romania', 'Estonia', 'Bhutan', 'Croatia', 'Solomon Islands', 'Guyana', 'Iceland', 'Vanuatu', 'Cape Verde', 'Samoa', 'Faroe Islands', 'Norway', 'Uruguay', 'Mongolia', 'United Arab Emirates', 'Slovenia', 'Bulgaria', 'Honduras', 'Columbia', 'Namibia', 'Switzerland', 'Western Sahara'
            AND lg5.admin0_grid_id NOT IN (100314737,100083318,100041128,100133112,100341242,100132648,100222839,100379914,100055707,100379993,100130389,100255271,100363975,100248845,100001527,100342458,100024289,100132795,100054605,100253456,100342975,100074571)

			# Total Records (38229)

       ", ARRAY_A );

        $list = [];
        if ( is_array( $results ) ) {
            foreach ( $results as $result ) {
                $list[$result['grid_id']] = $result;
            }
        }

        set_transient( __METHOD__, $list, MONTH_IN_SECONDS );

        return $list;
    }

    public static function query_flat_grid_by_level( $administrative_level, $us_div = 5000, $global_div = 50000 ) {
        global $wpdb;
        $wpdb->us_div = $us_div;
        $wpdb->global_div = $global_div;
        switch ( $administrative_level ) {
            case 'a0':
                $results = $wpdb->get_results("
                    # 'Needs' GROUPED BY country
                    SELECT tb0.admin0_grid_id as grid_id, loc.name,loc.country_code, SUM(tb0.population) as population, SUM(tb0.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             # 44395 Records
                             SELECT
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                                       FROM $wpdb->dt_location_grid lg11
                                                       WHERE lg11.level = 1
                                                         AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                                       FROM $wpdb->dt_location_grid lg22
                                                       WHERE lg22.level = 2
                                                         AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                    ) as tb0
                    LEFT JOIN $wpdb->dt_location_grid loc ON tb0.admin0_grid_id=loc.grid_id
                    GROUP BY tb0.admin0_grid_id
                ", ARRAY_A );
                break;
            case 'a1':
                $results = $wpdb->get_results("
                    # 'Needs' GROUPED BY state level
                    SELECT tb1.admin1_grid_id as grid_id, loc.name, loc.country_code, SUM(tb1.population) as population, SUM(tb1.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             SELECT
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                                       FROM $wpdb->dt_location_grid lg11
                                                       WHERE lg11.level = 1
                                                         AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                                       FROM $wpdb->dt_location_grid lg22
                                                       WHERE lg22.level = 2
                                                         AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                    ) as tb1
                    LEFT JOIN $wpdb->dt_location_grid loc ON tb1.admin1_grid_id=loc.grid_id
                    GROUP BY tb1.admin1_grid_id
                ", ARRAY_A );
                break;
            case 'a2':
                $results = $wpdb->get_results("
                    # 'Needs' GROUPED BY county level
                    SELECT tb2.admin2_grid_id as grid_id, loc.name, loc.country_code, SUM(tb2.population) as population, SUM(tb2.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             SELECT
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                 FROM $wpdb->dt_location_grid lg11
                                 WHERE lg11.level = 1
                               AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                 ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                 FROM $wpdb->dt_location_grid lg22
                                 WHERE lg22.level = 2
                               AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                 ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                 ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                 ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                    ) as tb2
                    LEFT JOIN $wpdb->dt_location_grid loc ON tb2.admin2_grid_id=loc.grid_id
                    GROUP BY tb2.admin2_grid_id
                ", ARRAY_A );
                break;
            case 'a3':
                $results = $wpdb->get_results("
                    # 'Needs' GROUPED BY sub-county level
                    SELECT tb3.admin3_grid_id as grid_id, loc.name, loc.country_code, SUM(tb3.population) as population, SUM(tb3.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             # 44395 Records
                             SELECT
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                                       FROM $wpdb->dt_location_grid lg11
                                                       WHERE lg11.level = 1
                                                         AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                                       FROM $wpdb->dt_location_grid lg22
                                                       WHERE lg22.level = 2
                                                         AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                    ) as tb3
                    LEFT JOIN $wpdb->dt_location_grid loc ON tb3.admin3_grid_id=loc.grid_id
                    WHERE tb3.admin3_grid_id IS NOT NULL
                    GROUP BY tb3.admin3_grid_id
                ", ARRAY_A );
                break;
            case 'world':
                $results = $wpdb->get_results("
                    # World
                    SELECT 1 as grid_id, 'World' as name,'' as country_code, SUM(tbw.population) as population, SUM(tbw.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             # 44395 Records
                             SELECT
                                 'World',
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                                       FROM $wpdb->dt_location_grid lg11
                                                       WHERE lg11.level = 1
                                                         AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 'World',
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                                       FROM $wpdb->dt_location_grid lg22
                                                       WHERE lg22.level = 2
                                                         AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 'World',
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 'World',
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 'World',
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                    ) as tbw
                    LEFT JOIN $wpdb->dt_location_grid loc ON 1=loc.grid_id
                    GROUP BY 'World';
                ", ARRAY_A );
                break;
            default:
                $results = $wpdb->get_results("
                    # 48367 Records
                    # 'Needs' GROUPED BY sub-county level
                    SELECT tb3.admin3_grid_id as grid_id, loc.name, loc.country_code, SUM(tb3.population) as population, SUM(tb3.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             # 44395 Records
                             SELECT
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                                       FROM $wpdb->dt_location_grid lg11
                                                       WHERE lg11.level = 1
                                                         AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                                       FROM $wpdb->dt_location_grid lg22
                                                       WHERE lg22.level = 2
                                                         AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                    ) as tb3
                    LEFT JOIN $wpdb->dt_location_grid loc ON tb3.admin3_grid_id=loc.grid_id
                    WHERE tb3.admin3_grid_id IS NOT NULL
                    GROUP BY tb3.admin3_grid_id

                    UNION ALL

                    # 'Needs' GROUPED BY county level
                    SELECT tb2.admin2_grid_id as grid_id, loc.name, loc.country_code, SUM(tb2.population) as population, SUM(tb2.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             SELECT
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                 FROM $wpdb->dt_location_grid lg11
                                 WHERE lg11.level = 1
                               AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                 ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                 FROM $wpdb->dt_location_grid lg22
                                 WHERE lg22.level = 2
                               AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                 ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                 ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                 ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                 (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                 100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                 100054605, 100253456, 100342975, 100074571)
                    ) as tb2
                    LEFT JOIN $wpdb->dt_location_grid loc ON tb2.admin2_grid_id=loc.grid_id
                    GROUP BY tb2.admin2_grid_id

                    UNION ALL

                    # 'Needs' GROUPED BY state level
                    SELECT tb1.admin1_grid_id as grid_id, loc.name, loc.country_code, SUM(tb1.population) as population, SUM(tb1.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             SELECT
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                                       FROM $wpdb->dt_location_grid lg11
                                                       WHERE lg11.level = 1
                                                         AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                                       FROM $wpdb->dt_location_grid lg22
                                                       WHERE lg22.level = 2
                                                         AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                    ) as tb1
                    LEFT JOIN $wpdb->dt_location_grid loc ON tb1.admin1_grid_id=loc.grid_id
                    GROUP BY tb1.admin1_grid_id

                    UNION ALL

                    # 'Needs' GROUPED BY country
                    SELECT tb0.admin0_grid_id as grid_id, loc.name,loc.country_code, SUM(tb0.population) as population, SUM(tb0.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             # 44395 Records
                             SELECT
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                                       FROM $wpdb->dt_location_grid lg11
                                                       WHERE lg11.level = 1
                                                         AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                                       FROM $wpdb->dt_location_grid lg22
                                                       WHERE lg22.level = 2
                                                         AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                    ) as tb0
                    LEFT JOIN $wpdb->dt_location_grid loc ON tb0.admin0_grid_id=loc.grid_id
                    GROUP BY tb0.admin0_grid_id

                    UNION ALL

                    # World
                    SELECT 1 as grid_id, 'World','' as country_code, SUM(tbw.population) as population, SUM(tbw.needed) as needed, (0) as reported, (0) as percent
                    FROM (
                             # 44395 Records
                             SELECT
                                 'World',
                                 lg1.admin0_grid_id,
                                 lg1.admin1_grid_id,
                                 lg1.admin2_grid_id,
                                 lg1.admin3_grid_id,
                                 lg1.population,
                                 IF(ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg1.population / IF(lg1.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg1
                             WHERE lg1.level = 0
                               AND lg1.grid_id NOT IN (SELECT lg11.admin0_grid_id
                                                       FROM $wpdb->dt_location_grid lg11
                                                       WHERE lg11.level = 1
                                                         AND lg11.admin0_grid_id = lg1.grid_id)
                               AND lg1.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg1.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 'World',
                                 lg2.admin0_grid_id,
                                 lg2.admin1_grid_id,
                                 lg2.admin2_grid_id,
                                 lg2.admin3_grid_id,
                                 lg2.population,
                                 IF(ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg2.population / IF(lg2.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg2
                             WHERE lg2.level = 1
                               AND lg2.grid_id NOT IN (SELECT lg22.admin1_grid_id
                                                       FROM $wpdb->dt_location_grid lg22
                                                       WHERE lg22.level = 2
                                                         AND lg22.admin1_grid_id = lg2.grid_id)
                               AND lg2.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg2.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 'World',
                                 lg3.admin0_grid_id,
                                 lg3.admin1_grid_id,
                                 lg3.admin2_grid_id,
                                 lg3.admin3_grid_id,
                                 lg3.population,
                                 IF(ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg3.population / IF(lg3.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg3
                             WHERE lg3.level = 2
                               AND lg3.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg3.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 'World',
                                 lg4.admin0_grid_id,
                                 lg4.admin1_grid_id,
                                 lg4.admin2_grid_id,
                                 lg4.admin3_grid_id,
                                 lg4.population,
                                 IF(ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg4.population / IF(lg4.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid lg4
                             WHERE lg4.level = 1
                               AND lg4.admin0_grid_id NOT IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg4.admin0_grid_id IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                             UNION ALL
                             SELECT
                                 'World',
                                 lg5.admin0_grid_id,
                                 lg5.admin1_grid_id,
                                 lg5.admin2_grid_id,
                                 lg5.admin3_grid_id,
                                 lg5.population,
                                 IF(ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div )) < 1, 1,
                                    ROUND(lg5.population / IF(lg5.country_code = 'US', $wpdb->us_div, $wpdb->global_div ))) as needed
                             FROM $wpdb->dt_location_grid as lg5
                             WHERE lg5.level = 3
                               AND lg5.admin0_grid_id IN (100050711, 100219347, 100089589, 100074576, 100259978, 100018514)
                               AND lg5.admin0_grid_id NOT IN
                                   (100314737, 100083318, 100041128, 100133112, 100341242, 100132648, 100222839, 100379914, 100055707,
                                    100379993, 100130389, 100255271, 100363975, 100248845, 100001527, 100342458, 100024289, 100132795,
                                    100054605, 100253456, 100342975, 100074571)
                    ) as tbw
                    LEFT JOIN $wpdb->dt_location_grid loc ON 1=loc.grid_id
                    GROUP BY 'World';
                ", ARRAY_A );
        }

        if ( empty( $results ) ) {
            return [];
        }
        return $results;
    }

    public static function query_church_grid_totals( $administrative_level = null ) {
        global $wpdb;

        switch ( $administrative_level ) {
            case 'a0':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                     SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                        JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t0
                    GROUP BY t0.admin0_grid_id
                    ", ARRAY_A );
                break;
            case 'a1':
                $results = $wpdb->get_results( "
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                        JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t1
                    GROUP BY t1.admin1_grid_id
                    ", ARRAY_A );
                break;
            case 'a2':
                $results = $wpdb->get_results( "
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                        JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t2
                    GROUP BY t2.admin2_grid_id
                    ", ARRAY_A );
                break;
            case 'a3':
                $results = $wpdb->get_results( "
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                        JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t3
                    GROUP BY t3.admin3_grid_id

                    ", ARRAY_A );
                break;
            case 'world':
                $results = $wpdb->get_results( "
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                             SELECT 'World'
                             FROM $wpdb->postmeta as pm
                                      JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                                      JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                             WHERE pm.meta_key = 'location_grid'
                         ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            case 'full': // full query including world
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                     SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                        JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION ALL
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                        JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION ALL
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                        JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION ALL
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                        JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t3
                    GROUP BY t3.admin3_grid_id
                    UNION ALL
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                             SELECT 'World'
                             FROM $wpdb->postmeta as pm
                                      JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                                      JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                             WHERE pm.meta_key = 'location_grid'
                         ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            default:
                $results = $wpdb->get_results( "
                        SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                        FROM (
                         SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                            FROM $wpdb->postmeta as pm
                            JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                            JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                            LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                            WHERE pm.meta_key = 'location_grid'
                        ) as t0
                        GROUP BY t0.admin0_grid_id
                        UNION ALL
                        SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                        FROM (
                            SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                            FROM $wpdb->postmeta as pm
                            JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                            JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                            LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                            WHERE pm.meta_key = 'location_grid'
                        ) as t1
                        GROUP BY t1.admin1_grid_id
                        UNION ALL
                        SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                        FROM (
                            SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                            FROM $wpdb->postmeta as pm
                            JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                            JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                            LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                            WHERE pm.meta_key = 'location_grid'
                        ) as t2
                        GROUP BY t2.admin2_grid_id
                        UNION ALL
                        SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                        FROM (
                            SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                            FROM $wpdb->postmeta as pm
                            JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'groups'
                            JOIN $wpdb->postmeta as pm2 ON pm2.post_id=pm.post_id AND pm2.meta_key = 'group_type' AND pm2.meta_value = 'church'
                            LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                            WHERE pm.meta_key = 'location_grid'
                        ) as t3
                        GROUP BY t3.admin3_grid_id
                        ", ARRAY_A );
                    break;
        }

        $list = [];
        if ( is_array( $results ) ) {
            foreach ( $results as $result ) {
                if ( empty( $result['grid_id'] ) ) {
                    continue;
                }
                if ( empty( $result['count'] ) ) {
                    continue;
                }
                $list[$result['grid_id']] = $result['count'];
            }
        }

        return $list;
    }

    public static function query_training_grid_totals( $administrative_level = null ) {
        global $wpdb;

        switch ( $administrative_level ) {
            case 'a0':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                     SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t0
                    GROUP BY t0.admin0_grid_id
                    ", ARRAY_A );
                break;
            case 'a1':
                $results = $wpdb->get_results( "
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t1
                    GROUP BY t1.admin1_grid_id
                    ", ARRAY_A );
                break;
            case 'a2':
                $results = $wpdb->get_results( "
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t2
                    GROUP BY t2.admin2_grid_id
                    ", ARRAY_A );
                break;
            case 'a3':
                $results = $wpdb->get_results( "
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t3
                    GROUP BY t3.admin3_grid_id
                    ", ARRAY_A );
                break;
            case 'world':
                $results = $wpdb->get_results( "
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                        SELECT 'World'
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            case 'full':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                     SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION ALL
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION ALL
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION ALL
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t3
                    GROUP BY t3.admin3_grid_id
                    UNION ALL
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                        SELECT 'World'
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            default:
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                     SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION ALL
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION ALL
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION ALL
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->postmeta as pm
                        JOIN $wpdb->posts as p ON p.ID=pm.post_id AND p.post_type = 'trainings'
                        LEFT JOIN $wpdb->dt_location_grid as lg ON pm.meta_value=lg.grid_id
                        WHERE pm.meta_key = 'location_grid'
                    ) as t3
                    GROUP BY t3.admin3_grid_id
                    ", ARRAY_A );
                break;
        }

        $list = [];
        if ( is_array( $results ) ) {
            foreach ( $results as $result ) {
                if ( empty( $result['grid_id'] ) ) {
                    continue;
                }
                if ( empty( $result['count'] ) ) {
                    continue;
                }
                $list[$result['grid_id']] = $result['count'];
            }
        }

        return $list;
    }


    public static function query_registration_grid_totals( $administrative_level = null ) {
        global $wpdb;

        switch ( $administrative_level ) {
            case 'a0':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t0
                    GROUP BY t0.admin0_grid_id
                    ", ARRAY_A );
                break;
            case 'a1':
                $results = $wpdb->get_results( "
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t1
                    GROUP BY t1.admin1_grid_id
                    ", ARRAY_A );
                break;
            case 'a2':
                $results = $wpdb->get_results( "
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t2
                    GROUP BY t2.admin2_grid_id
                    ", ARRAY_A );
                break;
            case 'a3':
                $results = $wpdb->get_results( "
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t3
                    GROUP BY t3.admin3_grid_id
                    ", ARRAY_A );
                break;
            case 'world':
                $results = $wpdb->get_results( "
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                        SELECT 'World'
                        FROM $wpdb->usermeta as um
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                        WHERE um.meta_key = 'zume_location_grid_from_ip'
                    ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            case 'full':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION ALL
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION ALL
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION ALL
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t3
                    GROUP BY t3.admin3_grid_id
                    UNION ALL
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                        SELECT 'World'
                        FROM $wpdb->usermeta as um
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                        WHERE um.meta_key = 'zume_location_grid_from_ip'
                    ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            default:
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION ALL
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION ALL
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION ALL
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t3
                    GROUP BY t3.admin3_grid_id
                    ", ARRAY_A );
                break;
        }

        $list = [];
        if ( is_array( $results ) ) {
            foreach ( $results as $result ) {
                if ( empty( $result['grid_id'] ) ) {
                    continue;
                }
                if ( empty( $result['count'] ) ) {
                    continue;
                }
                $list[$result['grid_id']] = $result['count'];
            }
        }

        return $list;
    }

    public static function query_trained_people_grid_totals( $administrative_level = null ) {
        global $wpdb;

        switch ( $administrative_level ) {
            case 'a0':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t0
                    GROUP BY t0.admin0_grid_id
                    ", ARRAY_A );
                break;
            case 'a1':
                $results = $wpdb->get_results( "
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t1
                    GROUP BY t1.admin1_grid_id
                    ", ARRAY_A );
                break;
            case 'a2':
                $results = $wpdb->get_results( "
                     SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t2
                    GROUP BY t2.admin2_grid_id
                    ", ARRAY_A );
                break;
            case 'a3':
                $results = $wpdb->get_results( "
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t3
                    GROUP BY t3.admin3_grid_id
                    ", ARRAY_A );
                break;
            case 'world':
                $results = $wpdb->get_results( "
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                        SELECT 'World'
                        FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                        WHERE um.meta_key = 'zume_location_grid_from_ip'
                    ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            case 'full':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION ALL
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION ALL
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION ALL
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                                      LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t3
                    GROUP BY t3.admin3_grid_id
                    UNION ALL
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                            SELECT 'World'
                            FROM $wpdb->usermeta as um
                            JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                            LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                            WHERE um.meta_key = 'zume_location_grid_from_ip'
                    ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            default:
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION ALL
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION ALL
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION ALL
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                             FROM $wpdb->usermeta as um
                             JOIN $wpdb->usermeta uc ON uc.user_id=um.user_id AND uc.meta_key = 'zume_training_complete'
                             LEFT JOIN $wpdb->dt_location_grid as lg ON um.meta_value=lg.grid_id
                             WHERE um.meta_key = 'zume_location_grid_from_ip'
                         ) as t3
                    GROUP BY t3.admin3_grid_id
                    ", ARRAY_A );
                break;
        }

        $list = [];
        if ( is_array( $results ) ) {
            foreach ( $results as $result ) {
                if ( empty( $result['grid_id'] ) ) {
                    continue;
                }
                if ( empty( $result['count'] ) ) {
                    continue;
                }
                $list[$result['grid_id']] = $result['count'];
            }
        }

        return $list;
    }

    public static function query_activity_grid_totals( $administrative_level = null ) {
        global $wpdb;

        switch ( $administrative_level ) {
            case 'a0':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                     SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t0
                    GROUP BY t0.admin0_grid_id
                    ", ARRAY_A );
                break;
            case 'a1':
                $results = $wpdb->get_results( "
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t1
                    GROUP BY t1.admin1_grid_id
                    ", ARRAY_A );
                break;
            case 'a2':
                $results = $wpdb->get_results( "
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t2
                    GROUP BY t2.admin2_grid_id
                    ", ARRAY_A );
                break;
            case 'a3':
                $results = $wpdb->get_results( "
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t3
                    GROUP BY t3.admin2_grid_id
                    ", ARRAY_A );
                break;
            case 'world':
                $results = $wpdb->get_results( "
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                        SELECT 'World'
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            case 'full':
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                     SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t3
                    GROUP BY t3.admin3_grid_id;
                    UNION ALL
                    SELECT 1 as grid_id, count('World') as count
                    FROM (
                        SELECT 'World'
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as tw
                    GROUP BY 'World'
                    ", ARRAY_A );
                break;
            default:
                $results = $wpdb->get_results( "
                    SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
                    FROM (
                     SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t0
                    GROUP BY t0.admin0_grid_id
                    UNION
                    SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t1
                    GROUP BY t1.admin1_grid_id
                    UNION
                    SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t2
                    GROUP BY t2.admin2_grid_id
                    UNION
                    SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
                    FROM (
                        SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                        FROM $wpdb->dt_movement_log ml
                        LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                        WHERE ml.grid_id != 0
                    ) as t3
                    GROUP BY t3.admin3_grid_id;
                    ", ARRAY_A );
                break;
        }

        $list = [];
        if ( is_array( $results ) ) {
            foreach ( $results as $result ) {
                if ( empty( $result['grid_id'] ) ) {
                    continue;
                }
                if ( empty( $result['count'] ) ) {
                    continue;
                }
                $list[$result['grid_id']] = $result['count'];
            }
        }

        return $list;
    }

    public static function query_activity_location_grid_totals() {

        global $wpdb;

        $results = $wpdb->get_results( "
        SELECT t0.admin0_grid_id as grid_id, count(t0.admin0_grid_id) as count
            FROM (
             SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                FROM $wpdb->dt_movement_log ml
                LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                WHERE ml.grid_id != 0
            ) as t0
            GROUP BY t0.admin0_grid_id
            UNION
            SELECT t1.admin1_grid_id as grid_id, count(t1.admin1_grid_id) as count
            FROM (
                SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                FROM $wpdb->dt_movement_log ml
                LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                WHERE ml.grid_id != 0
            ) as t1
            GROUP BY t1.admin1_grid_id
            UNION
            SELECT t2.admin2_grid_id as grid_id, count(t2.admin2_grid_id) as count
            FROM (
                SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                FROM $wpdb->dt_movement_log ml
                LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                WHERE ml.grid_id != 0
            ) as t2
            GROUP BY t2.admin2_grid_id
            UNION
            SELECT t3.admin3_grid_id as grid_id, count(t3.admin3_grid_id) as count
            FROM (
                SELECT lg.admin0_grid_id, lg.admin1_grid_id, lg.admin2_grid_id, lg.admin3_grid_id, lg.admin4_grid_id, lg.admin5_grid_id
                FROM $wpdb->dt_movement_log ml
                LEFT JOIN $wpdb->dt_location_grid lg ON lg.grid_id=ml.grid_id
                WHERE ml.grid_id != 0
            ) as t3
            GROUP BY t3.admin3_grid_id;
        ", ARRAY_A );

        $list = [];
        if ( is_array( $results ) ) {
            foreach ( $results as $result ) {
                $list[$result['grid_id']] = $result;
            }
        }

        return $list;
    }

    public static function query_grid_elements( $grid_id ) {
        global $wpdb;

        $result = $wpdb->get_row($wpdb->prepare( "
            SELECT
                   lg.admin3_grid_id as a3,
                   lg.admin2_grid_id as a2,
                   lg.admin1_grid_id as a1,
                   lg.admin0_grid_id as a0,
                   1 as world,
                   lg3.population as a3_population,
                   lg2.population as a2_population,
                   lg1.population as a1_population,
                   lg0.population as a0_population,
                   lgw.population as world_population,
                   lg.country_code
            FROM $wpdb->dt_location_grid lg
            LEFT JOIN $wpdb->dt_location_grid lg0 ON lg.admin0_grid_id=lg0.grid_id
            LEFT JOIN $wpdb->dt_location_grid lg1 ON lg.admin1_grid_id=lg1.grid_id
            LEFT JOIN $wpdb->dt_location_grid lg2 ON lg.admin2_grid_id=lg2.grid_id
            LEFT JOIN $wpdb->dt_location_grid lg3 ON lg.admin3_grid_id=lg3.grid_id
            LEFT JOIN $wpdb->dt_location_grid lgw ON 1=lgw.grid_id
            WHERE lg.grid_id = %s
        ", $grid_id ), ARRAY_A );

        return $result;
    }

}
