<?php
declare(strict_types=1);

namespace App\Formatos;

class SpotifyStream implements AudioFile {
    private string $title;
    private string $apiResult = "";

    public function __construct(string $title) {
        $this->title = $title;
        $this->conectarAPIAudio();
    }

    private function conectarAPIAudio(): void {
        // Codificamos el título para que sea una URL válida (ej: "Blinding Lights" -> "Blinding+Lights")
        $terminoBusqueda = urlencode($this->title);
        $url = "https://itunes.apple.com/search?term={$terminoBusqueda}&limit=1&entity=song";

        // CONFIGURACIÓN REAL DE INTERNET: Nos conectamos a la API
        $opciones = [
            "http" => [
                "header" => "User-Agent: PHP-Music-App/1.0\r\n"
            ]
        ];
        $contexto = stream_context_create($opciones);
        
        // Hacemos la petición web en tiempo real
        $respuesta = @file_get_contents($url, false, $contexto);

        if ($respuesta !== false) {
            $datos = json_decode($respuesta, true);
            if (!empty($datos['results'])) {
                // Si encontró la canción en internet, guardamos la URL de preescucha real
                $this->apiResult = $datos['results'][0]['previewUrl'];
                // Actualizamos el título con el nombre exacto oficial del artista y canción
                $this->title = $datos['results'][0]['artistName'] . " - " . $datos['results'][0]['trackName'];
            } else {
                $this->apiResult = "No se encontró el enlace en el servidor externo.";
            }
        } else {
            $this->apiResult = "Error de conexión con el servidor de streaming.";
        }
    }

    public function getSource(): string { 
        return "URL de Streaming Real de Internet: " . $this->apiResult; 
    }
    
    public function getTitle(): string { 
        return $this->title; 
    }
}