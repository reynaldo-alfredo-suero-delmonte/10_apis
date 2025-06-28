<?php
$nombre = "";
$datos = null;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = strtolower(trim($_POST["nombre"]));
    if (!empty($nombre)) {
        $url = "https://pokeapi.co/api/v2/pokemon/" . urlencode($nombre);
        $respuesta = @file_get_contents($url);

        if ($respuesta !== false) {
            $datos = json_decode($respuesta, true);
        } else {
            $error = "Pokémon no encontrado. Verifica el nombre.";
        }
    } else {
        $error = "Por favor, ingresa el nombre de un Pokémon.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Pokémon Info ⚡</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to right, #ffcb05, #3b4cca);
      color: white;
    }
    .pokemon-card {
      background-color: rgba(0, 0, 0, 0.6);
      border-radius: 20px;
      padding: 20px;
    }
    .poke-img {
      width: 200px;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Volver al Inicio</a>
  </div>
</nav>

<main class="container mt-5">
  <h2 class="text-center mb-4">Informacion de un pokemon</h2>

  <form method="POST" action="" class="mb-4">
    <div class="mb-3">
      <label for="nombre" class="form-label">Pokemon:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Buscar</button>
  </form>

  <?php if ($datos): ?>
    <div class="pokemon-card text-center mx-auto" style="max-width: 500px;">
      <h3 class="text-capitalize"><?= htmlspecialchars($nombre) ?></h3>
      <img src="<?= $datos["sprites"]["front_default"] ?>" alt="Imagen de <?= $nombre ?>" class="poke-img mb-3">

      <p><strong>Experiencia:</strong> <?= $datos["base_experience"] ?></p>

      <p><strong>Habilidades:</strong></p>
      <ul class="list-group list-group-flush mb-3">
        <?php foreach ($datos["abilities"] as $hab): ?>
          <li class="list-group-item bg-transparent text-white border-light"><?= $hab["ability"]["name"] ?></li>
        <?php endforeach; ?>
      </ul>

      <?php
      $audioURL = "https://pokemoncries.com/cries-old/" . strtolower($nombre) . ".mp3";
      ?>

      <audio controls>
        <source src="<?= $audioURL ?>" type="audio/mpeg">
        Tu navegador no soporta audio.
      </audio>
    </div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
