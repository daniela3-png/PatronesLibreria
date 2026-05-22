<?php
declare(strict_types=1);

namespace App\Observadores;

use App\Formatos\AudioFile;

interface PlayerObserver {
    public function update(AudioFile $song): void;
}