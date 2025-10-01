<?php

class PG_Badge {
    private string $id;
    private string $title;
    private string $description_unearned;
    private string $description_earned;
    private string $image;
    private string $bw_image;
    private string $category;
    private int $value;
    private string $type;
    private array $progression_badges;
    private bool $hidden;
    private bool $deprecated;
    private bool $has_earned_badge;
    private int $timestamp;
    private int $num_times_earned;
    private int $progression_value;
    public function __construct(
        string $id = '',
        string $title = '',
        string $description_unearned = '',
        string $description_earned = '',
        string $image = '',
        string $bw_image = '',
        string $category = '',
        int $value = 0,
        string $type = '',
        array $progression_badges = [],
        bool $hidden = false,
        bool $deprecated = false
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description_unearned = $description_unearned;
        $this->description_earned = $description_earned;
        $this->image = $image;
        $this->bw_image = $bw_image;
        $this->category = $category;
        $this->value = $value;
        $this->type = $type;
        $this->progression_badges = $progression_badges;
        $this->hidden = $hidden;
        $this->deprecated = $deprecated;
        $this->has_earned_badge = false;
        $this->timestamp = 0;
        $this->num_times_earned = 0;
        $this->progression_value = 0;
    }

    public function get_id(): string {
        return $this->id;
    }

    public function get_image(): string {
        return $this->image;
    }

    public function get_bw_image(): string {
        return $this->bw_image;
    }

    public function get_title(): string {
        return $this->title;
    }

    public function get_description_unearned(): string {
        return $this->description_unearned;
    }

    public function get_description_earned(): string {
        return $this->description_earned;
    }

    public function get_category(): string {
        return $this->category;
    }

    public function get_value(): int {
        return $this->value;
    }

    public function get_type(): string {
        return $this->type;
    }

    public function get_progression_badges(): array {
        return $this->progression_badges;
    }

    public function equals( PG_Badge $badge ): bool {
        return $this->id === $badge->id &&
            $this->value === $badge->value;
    }

    public function less_than( PG_Badge $badge ): bool {
        return $this->value < $badge->value;
    }

    public function is_hidden(): bool {
        return $this->hidden;
    }

    public function is_deprecated(): bool {
        return $this->deprecated;
    }

    public function to_array(): array {
        if ( count( $this->progression_badges ) > 0 ) {
            $progression_badges = array_map( function( PG_Badge $badge ) {
                return $badge->to_array();
            }, $this->progression_badges );
        } else {
            $progression_badges = [];
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description_unearned' => $this->description_unearned,
            'description_earned' => $this->description_earned,
            'image' => $this->image,
            'bw_image' => $this->bw_image,
            'category' => $this->category,
            'value' => $this->value,
            'type' => $this->type,
            'progression_badges' => $progression_badges,
            'hidden' => $this->hidden,
            'deprecated' => $this->deprecated,
            'has_earned_badge' => $this->has_earned_badge,
            'timestamp' => $this->timestamp,
            'num_times_earned' => $this->num_times_earned,
            'progression_value' => $this->progression_value,
        ];
    }

    public function set_progression_root_badge( PG_Badge $badge ): void {
        $this->id = $badge->id;
        $this->title = $badge->title;
        $this->description_unearned = $badge->description_unearned;
        $this->description_earned = $badge->description_earned;
        $this->image = $badge->image;
        $this->bw_image = $badge->bw_image;
        $this->category = $badge->category;
        $this->value = $badge->value;
        $this->type = $badge->type;
        $this->hidden = $badge->hidden;
        $this->deprecated = $badge->deprecated;
        $this->has_earned_badge = $badge->has_earned_badge;
        $this->timestamp = $badge->timestamp;
        $this->progression_value = $badge->progression_value;
    }

    public function set_num_times_earned( int $num_times_earned ): void {
        $this->num_times_earned = $num_times_earned;
    }

    public function set_has_earned_badge( bool $has_earned_badge ): void {
        $this->has_earned_badge = $has_earned_badge;
    }

    public function set_timestamp( int $timestamp ): void {
        $this->timestamp = $timestamp;
    }

    public function set_progression_value( int $progression_value ): void {
        $this->progression_value = $progression_value;
    }
}
