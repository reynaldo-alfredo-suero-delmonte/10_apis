<?php
$nombre = "";
$edad = "";
$categoria = "";
$emoji = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $url = "https://api.agify.io/?name=" . urlencode($nombre);
    $respuesta = @file_get_contents($url);

    if ($respuesta != false) {
        $datos = json_decode($respuesta, true);
        if (isset($datos["age"]) && $datos["age"] != null) {
            $edad = $datos["age"];
            if ($edad < 18) {
                $categoria = "Joven";
            } elseif ($edad < 60) {
                $categoria = "Adulto";
            } else {
                $categoria = "Anciano";
            }
        } else {
            $error = "No se pudo estimar la edad";
        }
    } else {
        $error = "Error al conectar con la API";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Prediccion de edad</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Volver al inicio</a>
  </div>
</nav>

<main class="container mt-5">
  <h2 class="text-center mb-4">Prediccion de edad</h2>

  <form method="POST" action="" class="mb-4">
    <div class="mb-3">
      <label for="nombre" class="form-label">Ingresa un nombre:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Predecir</button>
  </form>

  <?php if ($edad !== ""): ?>
    <div class="text-center fs-5">
      <p><strong><?= htmlspecialchars($nombre) ?></strong> tiene <strong><?= $edad ?> años</strong>.</p>
      <p class="fw-bold"><?= $categoria ?></p>
    </div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

