<?php
declare(strict_types=1);

namespace App\Formatos;

interface AudioFile {
    public function getSource(): string;
    public function getTitle(): string;
}