<?php
add_action( 'init', 'pg_login_redirect_login_page' );
function pg_login_redirect_login_page(){
    if ( isset( $_SERVER['REQUEST_URI'] ) && !empty( $_SERVER['REQUEST_URI'] ) ){
        $parsed_request_uri = ( new DT_URL( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) )->parsed_url;
        $page_viewed = ltrim( $parsed_request_uri['path'], '/' );

        if ( $page_viewed == 'wp-login.php' && isset( $_GET['action'] ) && $_GET['action'] === 'register' ){
            wp_redirect( site_url( 'login' ) );
            exit;
        }
    }
}

/* add_filter( 'login_url', function ( $url ) {
    if ( str_contains( $url, 'wp-login.php' ) ) {
        $url = str_replace( 'wp-login.php', 'login', $url );
    }
    return $url;
}, 100, 1 ); */


add_action( 'dt_sso_login_extra_fields', function ( $extra_fields, $body ){
    if ( !empty( $extra_fields['tshirt'] ) ){
        update_user_meta( get_current_user_id(), 'pg_tshirt', true );
        pg_icom_tshirt();
    }
    if ( !empty( $extra_fields['marketing'] ) ){
        update_user_meta( get_current_user_id(), 'pg_send_general_emails', true );
        pg_connect_to_crm();
    }
}, 10, 2 );

function pg_connect_to_crm(){

    $key = Site_Link_System::get_site_key_by_dev_key( 'crm_connection' );
    if ( empty( $key ) ){
        return;
    }

    $site_key = md5( $key['token'] . $key['site1'] . $key['site2'] );
    $transfer_token = Site_Link_System::create_transfer_token_for_site( $site_key );

    $url = 'https://' . $key['site2'] . '/wp-json/dt-posts/v2/contacts?check_for_duplicates=contact_email&silent=true';

    $current_user = wp_get_current_user();

    $fields = [
        'title' => $current_user->display_name,
        'contact_email' => [ [ 'value' => $current_user->user_email ] ],
        'sources' => [ 'values' => [ [ 'value' => 'prayer_global' ] ] ],
        'steps_taken' => [ 'values' => [ [ 'value' => 'P.G Newsletter' ] ] ],
        'tags' => [ 'values' => [ [ 'value' => 'add_to_mailing_list_39' ] ] ], //P.G Newsletter
        'projects' => [ 'values' => [ [ 'value' => 'prayer_global' ] ] ],
    ];

    $request = wp_remote_post( $url, [
        'body' => $fields,
        'headers' => [
            'Authorization' => 'Bearer ' . $transfer_token,
        ],
    ] );
}

function pg_icom_tshirt( $set_tag = true ){
    //get current contact
    $current_user_id = get_current_user_id();
    $contact_id = Disciple_Tools_Users::get_contact_for_user( $current_user_id );
    $update = [
        'tags' => [ 'values' => [ [ 'value' => 'icom_tshirt' ] ] ],
    ];
    if ( !$set_tag ){
        $update['tags']['values'][0]['value']['delete'] = true;
    }

    DT_Posts::update_post( 'contacts', $contact_id, $update, true, false );
}
