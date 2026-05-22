<?php
declare(strict_types=1);

namespace App\Observadores;

use App\Formatos\AudioFile;

class PlayHistory implements PlayerObserver {
    private string $archivoHistorial = __DIR__ . '/../../historial.txt';

    public function update(AudioFile $song): void { 
        date_default_timezone_set('America/Santiago');
        $fechaHora = date('Y-m-d H:i:s');
        
        $lineaRegistro = "[{$fechaHora}] Canción escuchada: {$song->getTitle()}\n";
        
        file_put_contents($this->archivoHistorial, $lineaRegistro, FILE_APPEND);

        echo "   -> [HISTORIAL] ¡Éxito! Guardado físicamente en 'historial.txt'\n"; 
    }
}