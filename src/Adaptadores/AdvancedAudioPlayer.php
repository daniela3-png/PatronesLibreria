<?php
declare(strict_types=1);

namespace App\Adaptadores;

class AdvancedAudioPlayer {
    public function renderVlcTrack(): string { 
        return "Decodificando flujo de bits VLC de alta fidelidad"; 
    }
    
    public function fetchVlcTitle(): string {
        return "Pista VLC Externa (Formato .vlc)";
    }
}