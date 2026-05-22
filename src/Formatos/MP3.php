<?php
declare(strict_types=1);

namespace App\Formatos;

class MP3 implements AudioFile {
    private string $title;

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function getSource(): string { 
        return "Streaming de archivo local MP3 (Almacenamiento local)"; 
    }
    
    public function getTitle(): string { 
        return $this->title; 
    }
}