<?php
$setup = "";
$punchline = "";
$error = "";

$url = "https://official-joke-api.appspot.com/random_joke";
$respuesta = @file_get_contents($url);

if ($respuesta != false) {
    $datos = json_decode($respuesta, true);
    if (isset($datos["setup"]) && isset($datos["punchline"])) {
        $setup = $datos["setup"];
        $punchline = $datos["punchline"];
    } else {
        $error = "La API no devolvió un chiste válido.";
    }
} else {
    $error = "No se pudo conectar con la API.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Chiste aleatorio</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fceabb;
      background-image: linear-gradient(315deg, #fceabb 0%, #f8b500 74%);
    }
  </style>
</head>
<body>

<nav class="navbar navbar-dark bg-warning">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Volver al inicio</a>
  </div>
</nav>

<main class="container mt-5">
  <h2 class="text-center mb-4">Preparado?</h2>

  <?php if ($setup && $punchline): ?>
    <div class="alert alert-light text-center fs-5 shadow">
      <p><strong><?= $setup ?></strong></p>
      <p class="mt-3"><em><?= $punchline ?></em></p>
    </div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>

  <div class="text-center mt-4">
    <a href="chistes.php" class="btn btn-warning">Otro</a>
  </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
