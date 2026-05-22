<?php
declare(strict_types=1);

namespace App\Observadores;

use App\Formatos\AudioFile;

class PlayHistory implements PlayerObserver {
    public function update(AudioFile $song): void { 
        echo "   -> [HISTORIAL BD] Reaccionando: Guardando '{$song->getTitle()}' en el registro de canciones escuchadas\n"; 
    }
}