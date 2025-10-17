<?php

class PG_Notification {
    public string $message;
    public string $title;
    public string $url;
    public array $data;
    public string $category;
    public int $value;

    public function __construct( string $message, string $title, string $url, array $data, string $category, int $value ) {
        $this->message = $message;
        $this->title = $title;
        $this->url = $url;
        $this->data = $data;
        $this->category = $category;
        $this->value = $value;
    }

    public static function from_milestone( PG_Milestone $milestone ) {
        return new self(
            $milestone->get_message(),
            $milestone->get_title(),
            $milestone->get_url(),
            $milestone->to_array(),
            $milestone->get_category(),
            $milestone->get_value(),
        );
    }

    public static function from_badge( PG_Badge $badge ) {
        $title = __( 'You\'ve earned a new badge!', 'prayer-global-porch' );
        $message = $badge->get_description_earned();
        $url = site_url( '/dashboard/badges/' . $badge->get_id() );

        return new self(
            $message,
            $title,
            $url,
            [],
            $badge->get_id(),
            $badge->get_value()
        );
    }

    public static function from_badges( array $badges ) {
        $title = __( 'You\'ve earned new badges!', 'prayer-global-porch' );
        $message = __( 'Congratulations on your new badges!', 'prayer-global-porch' );
        $url = site_url( '/dashboard/badges' );
        $data = array_map( function( PG_Badge $badge ) {
            return $badge->to_array();
        }, $badges );

        return new self(
            $message,
            $title,
            $url,
            $data,
            'badges',
            count( $badges )
        );
    }
}
