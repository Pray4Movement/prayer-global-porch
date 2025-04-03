<?php

class PG_Milestone {
    private string $title;
    private string $message;
    private string $category;
    private int $value;
    private array $channels;

    public function __construct(
        string $title,
        string $message,
        string $category,
        int $value,
        array $channel
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->category = $category;
        $this->value = $value;
        $this->channels = $channel;
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
        return $this->channels;
    }

    public function to_array(): array {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'category' => $this->category,
            'value' => $this->value,
            'channel' => $this->channels,
        ];
    }

    public function in_app() {
        return in_array( 'in-app', $this->channels );
    }
}
