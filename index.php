<?php
declare(strict_types=1);

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

// Inicializa reproductor y observadores
$player = new MusicPlayer();
$pantalla = new InterfaceDisplay();
$historial = new PlayHistory();
$player->attach($pantalla);
$player->attach($historial);

// Captura la canción que el usuario quiere buscar (por defecto "Blinding Lights")
$cancionBuscar = $_GET['buscar'] ?? 'Blinding Lights';

try {
    // Usa la fábrica para crear la canción consultando a la API real
    $cancion = AudioFactory::createAudio('spotify', $cancionBuscar);
    
    // Obtiene los datos reales mutados por los patrones
    $tituloOficial = $cancion->getTitle();
    $urlAudio = $cancion->getSource();
    
    // Limpia el prefijo de texto para dejar solo la URL limpia del streaming
    $urlLimpia = str_replace("URL de Streaming Real de Internet: ", "", $urlAudio);

} catch (Exception $e) {
    $error = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reproductor de Música - Patrones de Diseño</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #121212;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .player-card {
            background: #181818;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            width: 380px;
            text-align: center;
            border: 1px solid #282828;
        }
        .cover-art {
            width: 200px;
            height: 200px;
            background: linear-gradient(135deg, #1db954, #191414);
            margin: 0 auto 20px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }
        h2 { margin: 10px 0 5px; font-size: 1.4rem; color: #fff; }
        p { color: #b3b3b3; font-size: 0.9rem; margin-bottom: 25px; }
        audio { width: 100%; margin-top: 10px; }
        
        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .search-box input {
            flex: 1;
            padding: 8px 12px;
            border-radius: 20px;
            border: 1px solid #333;
            background: #2A2A2A;
            color: white;
            outline: none;
        }
        .search-box button {
            background: #1db954;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
        }
        .search-box button:hover { background: #1ed760; }
        .tag {
            display: inline-block;
            background: #282828;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.75rem;
            color: #1db954;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="player-card">
        <form method="GET" class="search-box">
            <input type="text" name="buscar" placeholder="Buscar canción o artista..." value="<?php echo htmlspecialchars($cancionBuscar); ?>">
            <button type="submit">Buscar</button>
        </form>

        <span class="tag">Patrón Factory + Observer Activos</span>
        
        <div class="cover-art">🎵</div>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php else: ?>
            <h2><?php echo htmlspecialchars($tituloOficial); ?></h2>
            <p>Reproduciendo desde API Externa</p>

            <audio controls autoplay src="<?php echo htmlspecialchars($urlLimpia); ?>">
                Tu navegador no soporta el elemento de audio.
            </audio>
        <?php endif; ?>
        
        <div style="font-size: 0.7rem; color: #555; margin-top: 15px;">
            Historial físico guardado en el servidor.
        </div>
    </div>

</body>
</html>