<?php
declare(strict_types=1);

namespace App\Observadores;

use App\Formatos\AudioFile;

class InterfaceDisplay implements PlayerObserver {
    public function update(AudioFile $song): void { 
        echo "   -> [PANTALLA UI] Reaccionando: Cambiando imagen de portada y título a '{$song->getTitle()}'\n"; 
    }
}