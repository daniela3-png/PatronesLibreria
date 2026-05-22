<?php
declare(strict_types=1);

// Este bloque es un Autocargador. Busca las carpetas automáticamente según el 'namespace'
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

use App\Formatos\AudioFactory;
use App\Adaptadores\AdvancedAudioPlayer;
use App\Adaptadores\VlcAdapter;
use App\Observadores\MusicPlayer;
use App\Observadores\InterfaceDisplay;
use App\Observadores\PlayHistory;

echo "===========================================================\n";
echo "   SISTEMA DE MÚSICA INICIADO (3 PATRONES DE DISEÑO)\n";
echo "===========================================================\n";

// 1. Configuramos el Reproductor y sus Observadores (Comportamiento)
$player = new MusicPlayer();
$pantalla = new InterfaceDisplay();
$historial = new PlayHistory();

// Suscribimos los observadores al reproductor
$player->attach($pantalla);
$player->attach($historial);

// 2. Creamos canciones usando la Fábrica (Creacional)
try {
    echo "\n--- Probando Patrón Creacional (Factory) ---\n";
    $cancionMP3 = AudioFactory::createAudio('mp3', 'Bohemian Rhapsody - Queen');
    $cancionSpotify = AudioFactory::createAudio('spotify', 'Blinding Lights - The Weeknd');
    
    // Las reproducimos (Esto disparará automáticamente los observadores)
    $player->playSong($cancionMP3);
    $player->playSong($cancionSpotify);

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

// 3. Introducimos una librería externa usando el Adaptador (Estructural)
echo "\n--- Probando Patrón Estructural (Adapter) ---\n";
$libreriaExterna = new AdvancedAudioPlayer();
$cancionVlcAdaptada = new VlcAdapter($libreriaExterna);

// El reproductor la reproduce como si fuera una canción nativa de nuestro sistema
$player->playSong($cancionVlcAdaptada);

echo "\n===========================================================\n";
echo "   SIMULACIÓN TERMINADA CON ÉXITO\n";
echo "===========================================================\n";