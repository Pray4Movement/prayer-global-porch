<?php

class PG_Badge {
    private string $id;
    private string $name;
    private string $description;
    private string $image;
    private string $url;
    private string $type;

    public function __construct( string $id, string $name, string $description, string $image, string $url, string $type ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->url = $url;
        $this->type = $type;
    }

    public function get_id(): string {
        return $this->id;
    }

    public function get_name(): string {
        return $this->name;
    }

    public function get_description(): string {
        return $this->description;
    }

    public function get_image(): string {
        return $this->image;
    }

    public function get_url(): string {
        return $this->url;
    }

    public function get_type(): string {
        return $this->type;
    }

    public function to_array(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'url' => $this->url,
            'type' => $this->type,
        ];
    }
}
