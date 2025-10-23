<?php

class PG_Milestone {
    private string $title;
    private string $message;
    private string $category;
    private int $value;
    private string $url;
    private array $channels;

    public function __construct(
        string $title,
        string $message,
        string $category,
        int $value,
        array $channel,
        string $url = '',
    ) {
        $this->title = $title;
        $this->message = $message;
        $this->category = $category;
        $this->value = $value;
        $this->channels = $channel;
        $this->url = $url;
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

    public function get_channels(): array {
        return $this->channels;
    }

    public function get_url(): string {
        return $this->url;
    }

    public function to_array(): array {
        return [
        'title' => $this->title,
        'message' => $this->message,
        'category' => $this->category,
        'value' => $this->value,
        'channel' => $this->channels,
        'url' => $this->url,
        ];
    }

    public function in_app() {
        return in_array( PG_CHANNEL_IN_APP, $this->channels );
    }

    public function push() {
        return in_array( PG_CHANNEL_PUSH, $this->channels );
    }

    public function email() {
        return in_array( PG_CHANNEL_EMAIL, $this->channels );
    }
}
