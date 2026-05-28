<?php

use WP_Queue\Job;

class PG_User_Email_Notification_Job extends Job {
    public int $user_id;
    public string $user_email;
    public string $user_language;
    public PG_Notification $notification;

    public function __construct( int $user_id, string $user_email, PG_Notification $notification, string $user_language = 'en_US' ) {
        $this->user_id = $user_id;
        $this->user_email = $user_email;
        $this->user_language = $user_language;
        $this->notification = $notification;
    }

    public function handle() {
        pg_switch_notifications_locale( $this->user_language );

        $subject = $this->notification->title;
        $body = $this->build_body();
        $headers = [ 'Content-Type: text/html; charset=UTF-8' ];

        $sent = wp_mail( $this->user_email, $subject, $body, $headers );

        if ( $sent === false ) {
            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                error_log( 'PG_User_Email_Notification_Job: failed to send email to user ' . $this->user_email );
            }
            return;
        }

        if ( $this->notification->category === 'badges' ) {
            foreach ( $this->notification->data as $badge ) {
                PG_Notifications_Sent::record( $this->user_id, PG_Notification::from_badge( PG_Badge::from_array( $badge ) ), PG_CHANNEL_EMAIL );
            }
        } else {
            PG_Notifications_Sent::record( $this->user_id, $this->notification, PG_CHANNEL_EMAIL );
        }
    }

    private function build_body(): string {
        $plugin_url   = Prayer_Global_Porch::get_url_path();
        $logo_url     = $plugin_url . 'pages/assets/images/favicons/android-chrome-192x192.png';
        $badges_url   = $plugin_url . 'pages/assets/images/badges/';
        $cta_url      = site_url( '/dashboard/badges/' );
        $brand_color  = '#11224e';
        $accent_color = '#f2944a';

        $headline   = esc_html( $this->notification->title );
        $cta_label  = esc_html__( 'View your badges', 'prayer-global-porch' );
        $brand_name = 'Prayer.Global';
        $footer_tag = esc_html__( 'Cover the World in Prayer', 'prayer-global-porch' );
        $logo_alt   = esc_attr( $brand_name );

        $badge_cards = '';
        if ( $this->notification->category === 'badges' ) {
            // Multi-badge: notification->data is an array of badge.to_array() entries.
            foreach ( $this->notification->data as $b ) {
                $badge_cards .= $this->render_badge_card(
                    $b['title'] ?? '',
                    $b['description_earned'] ?? '',
                    $b['image'] ?? '',
                    $badges_url
                );
            }
        } else {
            // Single badge: badge_title and badge_image live in data; description is the notification message.
            $badge_cards = $this->render_badge_card(
                $this->notification->data['badge_title'] ?? '',
                $this->notification->message,
                $this->notification->data['badge_image'] ?? '',
                $badges_url
            );
        }

        return <<<HTML
<!DOCTYPE html>
<html>
<body style="margin: 0; padding: 0; background: #f5f6f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; color: #1f2330; line-height: 1.5;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background: #f5f6f8; padding: 32px 16px;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0" style="max-width: 600px; width: 100%; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
          <tr>
            <td style="background: {$brand_color}; padding: 24px; text-align: center;">
              <img src="{$logo_url}" alt="{$logo_alt}" width="56" height="56" style="display: block; margin: 0 auto 8px; border-radius: 12px;">
              <div style="color: #ffffff; font-size: 18px; font-weight: 600; letter-spacing: 0.3px;">{$brand_name}</div>
            </td>
          </tr>
          <tr>
            <td style="padding: 32px 32px 16px; text-align: center;">
              <h1 style="margin: 0 0 8px; font-size: 24px; color: {$brand_color}; font-weight: 700;">{$headline}</h1>
            </td>
          </tr>
          <tr>
            <td style="padding: 0 32px;">
              {$badge_cards}
            </td>
          </tr>
          <tr>
            <td style="padding: 16px 32px 32px; text-align: center;">
              <a href="{$cta_url}" style="display: inline-block; padding: 14px 28px; background: {$accent_color}; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">{$cta_label}</a>
            </td>
          </tr>
          <tr>
            <td style="padding: 16px 32px 24px; text-align: center; border-top: 1px solid #eef0f4;">
              <div style="font-size: 13px; color: #6b7280;">{$brand_name} &middot; {$footer_tag}</div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
HTML;
    }

    private function render_badge_card( string $title, string $description, string $image, string $badges_url ): string {
        $title_html = esc_html( $title );
        $desc_html  = esc_html( $description );
        $image_tag  = '';
        if ( $image !== '' ) {
            $image_url = esc_url( $badges_url . $image );
            $image_tag = "<img src=\"{$image_url}\" alt=\"{$title_html}\" width=\"160\" height=\"160\" style=\"display: block; margin: 0 auto 12px; max-width: 160px; height: auto;\">";
        }
        return <<<HTML
<div style="text-align: center; padding: 8px 0 16px;">
  {$image_tag}
  <div style="font-size: 18px; font-weight: 600; color: #1f2330; margin-bottom: 6px;">{$title_html}</div>
  <div style="font-size: 15px; color: #4b5563; max-width: 440px; margin: 0 auto;">{$desc_html}</div>
</div>
HTML;
    }
}
