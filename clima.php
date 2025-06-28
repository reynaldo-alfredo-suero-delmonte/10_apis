<?php
$ciudad = "";
$temperatura = "";
$descripcion = "";
$error = "";
$estilo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ciudad = trim($_POST["ciudad"]);
    $url = "https://wttr.in/" . urlencode($ciudad) . "?format=j1";
    $respuesta = @file_get_contents($url);

    if ($respuesta != false) {
        $datos = json_decode($respuesta, true);

        if (isset($datos["current_condition"][0])) {
            $condicion = $datos["current_condition"][0];
            $temperatura = $condicion["temp_C"];
            $descripcion = $condicion["weatherDesc"][0]["value"];

            $descLower = strtolower($descripcion);
            if (strpos($descLower, "sun") != false || strpos($descLower, "sol") != false) {
                $estilo = "bg-warning text-dark";
            } elseif (strpos($descLower, "cloud") != false || strpos($descLower, "nublado") != false) {
                $estilo = "bg-secondary text-white";
            } elseif (strpos($descLower, "rain") !== false || strpos($descLower, "lluvia") != false) {
                $estilo = "bg-info text-white";
            } else {
                $estilo = "bg-light text-dark";
            }
        } else {
            $error = "No se encontró información del clima para esa ciudad.";
        }
    } else {
        $error = "No se pudo conectar con la API de clima.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clima en Republica Dominicana</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-info">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Volver al inicio</a>
  </div>
</nav>

<main class="container mt-5">
  <h2 class="text-center mb-4">Clima en Republica Dominicana</h2>

  <form method="POST" class="mb-4">
    <div class="mb-3">
      <label for="ciudad" class="form-label">Escribe una ciudad:</label>
      <input type="text" class="form-control" name="ciudad" id="ciudad" value="<?= htmlspecialchars($ciudad) ?>" required>
    </div>
    <button type="submit" class="btn btn-info">Clima</button>
  </form>

  <?php if ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php elseif ($temperatura): ?>
    <div class="p-4 rounded text-center <?= $estilo ?>">
      <h4><?= ucfirst(htmlspecialchars($ciudad)) ?>, Republica Dominicana</h4>
      <p class="fs-5"><strong><?= ucfirst($descripcion) ?></strong></p>
      <p class="fs-1"><?= $temperatura ?>°C</p>
    </div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
