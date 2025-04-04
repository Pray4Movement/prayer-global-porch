<?php

require_once __DIR__ . '/../../../wp-config.php';
add_filter( 'wp_queue_default_connection', function() {
    return 'sync';
} );

if ( defined( 'PG_ONESIGNAL_STOP' ) ) {
    echo 'PG_ONESIGNAL_STOP is defined as ' . esc_html( PG_ONESIGNAL_STOP ) . '<br>';
} else {
    echo 'PG_ONESIGNAL_STOP is not defined <br>';
}

if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'push_test' ) ) {
    if ( isset( $_POST['action'] ) && $_POST['action'] === 'push_job_test' ) {
        $user = isset( $_POST['user_email'] )
            ? get_user_by( 'email', sanitize_text_field( wp_unslash( $_POST['user_email'] ) ) )
            : get_user_by( 'email', 'nathinabob+1234@gmail.com' );
        $milestone_title = isset( $_POST['milestone_title'] ) ? sanitize_text_field( wp_unslash( $_POST['milestone_title'] ) ) : 'Test title';
        $milestone_text = isset( $_POST['milestone_text'] ) ? sanitize_text_field( wp_unslash( $_POST['milestone_text'] ) ) : 'Test text';
        $milestone = new PG_Milestone(
            $milestone_title,
            $milestone_text,
            'streak',
            1,
            [ PG_CHANNEL_PUSH ],
            site_url( 'dashboard' ),
        );
        wp_queue()->push( new PG_User_Push_Notification_Job( $user, $milestone ) );
        echo 'Push job test sent <br>';
        echo 'User: ' . esc_html( $user->user_email ) . '<br>';
        echo 'Milestone: ' . esc_html( $milestone_title ) . '<br>';
        echo 'Milestone text: ' . esc_html( $milestone_text ) . '<br>';
    }

    if ( isset( $_POST['action'] ) && $_POST['action'] === 'push_handler_test' ) {
        wp_queue()->push( new PG_Notification_Handler_Job() );
        echo 'Push handler test sent <br>';
    }
}
?>

<h2>Push Job Test</h2>
<form action="" method="post">
    <input type="hidden" name="action" value="push_job_test">
    <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'push_test' ) ); ?>">
    <input type="text" name="user_email" placeholder="User Email" required>
    <input type="text" name="milestone_title" placeholder="Milestone Title">
    <input type="text" name="milestone_text" placeholder="Milestone Text">
    <input type="submit" value="Send">
</form>

<h2>Push Handler Test</h2>
<form action="" method="post">
    <input type="hidden" name="action" value="push_handler_test">
    <input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'push_test' ) ); ?>">
    <input type="submit" value="Send">
</form>
