<?php

class PG_Badge {
    private string $id;
    private string $title;
    private string $description;
    private string $category;
    private int $value;
    private string $type;

    public function __construct( string $id, string $title, string $description, string $category, int $value, string $type ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->category = $category;
        $this->value = $value;
        $this->type = $type;
    }

    public function get_id(): string {
        return $this->id;
    }

    public function get_title(): string {
        return $this->title;
    }

    public function get_description(): string {
        return $this->description;
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

    public function to_array(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'value' => $this->value,
            'type' => $this->type,
        ];
    }
}
