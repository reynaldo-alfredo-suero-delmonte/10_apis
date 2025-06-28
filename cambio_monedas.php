<?php
$cantidad = "";
$conversiones = [];
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad = trim($_POST["cantidad"]);

    $url = "https://api.exchangerate-api.com/v4/latest/USD";
    $respuesta = @file_get_contents($url);

    if ($respuesta != false) {
        $datos = json_decode($respuesta, true);

        if (isset($datos["rates"]["DOP"])) {
            $conversiones["DOP"] = $cantidad * $datos["rates"]["DOP"];
            $conversiones["EUR"] = $cantidad * $datos["rates"]["EUR"];
            $conversiones["MX"] = $cantidad * $datos["rates"]["MX"];
            $conversiones["JP"] = $cantidad * $datos["rates"]["JP"];
        } else {
            $error = "No se encontraron tasas de cambio.";
        }
    } else {
        $error = "No se pudo conectar con la API.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Conversion de monedas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Volver al inicio</a>
  </div>
</nav>

<main class="container mt-5">
  <h2 class="text-center mb-4">Conversion de monedas</h2>

  <form method="POST" class="mb-4">
    <div class="mb-3">
      <label for="cantidad" class="form-label">Ingresa cantidad en dolares (USD):</label>
      <input type="number" step="0.01" class="form-control" id="cantidad" name="cantidad" value="<?= htmlspecialchars($cantidad) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Convertir</button>
  </form>

  <?php if (!empty($conversiones)): ?>
    <div class="alert alert-success">
      <h5>Resultados para <?= htmlspecialchars($cantidad) ?> USD:</h5>
      <ul class="list-group">
        <li class="list-group-item">Pesos dominicanos (DOP): <strong><?= number_format($conversiones["DOP"], 2) ?></strong></li>
        <li class="list-group-item">Euros (EUR): <strong><?= number_format($conversiones["EUR"], 2) ?></strong></li>
        <li class="list-group-item">Pesos mexicanos (MX): <strong><?= number_format($conversiones["MX"], 2) ?></strong></li>
        <li class="list-group-item">Yen japones (JP): <strong><?= number_format($conversiones["JP"], 2) ?></strong></li>
      </ul>
    </div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
