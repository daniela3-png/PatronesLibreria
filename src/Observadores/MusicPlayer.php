<?php
declare(strict_types=1);

namespace App\Observadores;

use App\Formatos\AudioFile;

class MusicPlayer {
    private array $observers = [];
    private ?AudioFile $currentSong = null;

    // Método para agregar observadores a la lista
    public function attach(PlayerObserver $observer): void { 
        $this->observers[] = $observer; 
    }

    // Cambiar canción y notificar a todos automáticamente
    public function playSong(AudioFile $song): void {
        $this->currentSong = $song;
        echo "\n[REPRODUCTOR] -> Sonando ahora: '" . $song->getTitle() . "'\n";
        echo "[REPRODUCTOR] -> Info origen: " . $song->getSource() . "\n";
        
        // Aquí se dispara la magia del Observer
        $this->notifyAll();
    }

    private function notifyAll(): void {
        foreach ($this->observers as $observer) {
            $observer->update($this->currentSong);
        }
    }
}