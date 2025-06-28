<?php
$nombre = "";
$genero = "";
$probabilidad = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $api = "https://api.genderize.io/?name=" . urlencode($nombre);
    $respuesta = @file_get_contents($api);

    if ($respuesta !== false) {
        $datos = json_decode($respuesta, true);
        if (isset($datos["gender"]) && $datos["gender"] !== null) {
            $genero = $datos["gender"];
            $probabilidad = $datos["probability"];
        } else {
            $error = "No se determino el genero";
        }
    } else {
        $error = "Error con la API";
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Predicción de genero</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .male { color: #0d6efd; }
    .female { color: #d63384; }
  </style>
</head>
<body>

<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Volver al inicio</a>
  </div>
</nav>

<main class="container mt-5">
  <h2 class="text-center mb-4">Prediccion de genero</h2>

  <form method="POST" action="" class="mb-4">
    <div class="mb-3">
      <label for="nombre" class="form-label">Ingresa un nombre:</label>
      <input type="text" class="form-control" name="nombre" id="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Predecir</button>
  </form>

  <?php if (!empty($genero)): ?>
    <div class="text-center fs-4">
      <?php if ($genero == "male"): ?>
        <p class="male">
          <strong><?= htmlspecialchars($nombre) ?></strong> es <strong>hombre 💙</strong>
          <br><small>(Probabilidad: <?= $probabilidad ?>)</small>
        </p>
      <?php elseif ($genero == "female"): ?>
        <p class="female">
          <strong><?= htmlspecialchars($nombre) ?></strong> es <strong>mujer 💖</strong>
          <br><small>Probabilidad: <?= $probabilidad ?></small>
        </p>
      <?php endif; ?>
    </div>
  <?php elseif (!empty($error)): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
