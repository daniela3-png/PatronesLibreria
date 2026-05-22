<?php
declare(strict_types=1);

namespace App\Formatos;

class SpotifyStream implements AudioFile {
    private string $title;

    public function __construct(string $title) {
        $this->title = $title;
    }

    public function getSource(): string { 
        return "Streaming desde los servidores de la API de Spotify"; 
    }
    
    public function getTitle(): string { 
        return $this->title; 
    }
}