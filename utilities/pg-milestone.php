<?php

class PG_Milestone {
    private string $icon;
    private string $title;
    private string $message;
    private string $category;
    private int $value;
    private array $channel;

    public function __construct(
        string $icon,
        string $title,
        string $message,
        string $category,
        int $value,
        array $channel
    ) {
        $this->icon = $icon;
        $this->title = $title;
        $this->message = $message;
        $this->category = $category;
        $this->value = $value;
        $this->channel = $channel;
    }

    public function get_icon(): string {
        return $this->icon;
    }

    public function get_title(): string {
        return $this->title;
    }

    public function get_message(): string {
        return $this->message;
    }

    public function get_category(): string {
        return $this->category;
    }

    public function get_value(): int {
        return $this->value;
    }

    public function get_channel(): array {
        return $this->channel;
    }

    public function to_array(): array {
        return [
            'icon' => $this->icon,
            'title' => $this->title,
            'message' => $this->message,
            'category' => $this->category,
            'value' => $this->value,
            'channel' => $this->channel,
        ];
    }

    public function in_app() {
        return in_array( 'in-app', $this->channel );
    }
}
