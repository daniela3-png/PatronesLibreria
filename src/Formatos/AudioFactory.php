<?php
declare(strict_types=1);

namespace App\Formatos;

use Exception;

class AudioFactory {
    public static function createAudio(string $type, string $title): AudioFile {
        return match(strtolower($type)) {
            'local', 'mp3' => new MP3($title),
            'spotify', 'streaming' => new SpotifyStream($title),
            default => throw new Exception("Error: El formato de audio '{$type}' no está soportado."),
        };
    }
}