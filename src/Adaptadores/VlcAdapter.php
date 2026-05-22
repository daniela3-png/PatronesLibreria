<?php
declare(strict_types=1);

namespace App\Adaptadores;

use App\Formatos\AudioFile;

class VlcAdapter implements AudioFile {
    private AdvancedAudioPlayer $advancedPlayer;

    // Recibimos la clase externa por el constructor
    public function __construct(AdvancedAudioPlayer $player) {
        $this->advancedPlayer = $player;
    }

    // Traducimos getSource() al método que entiende la librería externa
    public function getSource(): string {
        return $this->advancedPlayer->renderVlcTrack() . " [Traducido por Adaptador]";
    }

    // Traducimos getTitle()
    public function getTitle(): string {
        return $this->advancedPlayer->fetchVlcTitle();
    }
}