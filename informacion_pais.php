<?php
$pais = "";
$datos = null;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pais = trim($_POST["pais"]);
    $url = "https://restcountries.com/v3.1/name/" . urlencode($pais);
    $respuesta = @file_get_contents($url);

    if ($respuesta != false) {
        $resultados = json_decode($respuesta, true);
        if (is_array($resultados) && count($resultados) > 0) {
            $datos = $resultados[0]; 
        } else {
            $error = "No se encontró información para ese pais.";
        }
    } else {
        $error = "No se pudo conectar con la API";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Datos de un pais</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Volver al inicio</a>
  </div>
</nav>

<main class="container mt-5">
  <h2 class="text-center mb-4">Informacion de un pais</h2>

  <form method="POST" class="mb-4">
    <div class="mb-3">
      <label for="pais" class="form-label">Nombre del pais:</label>
      <input type="text" class="form-control" id="pais" name="pais" value="<?= htmlspecialchars($pais) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Buscar</button>
  </form>

  <?php if ($datos): ?>
    <div class="card text-center">
      <div class="card-header bg-success text-white">
        <h4><?= $datos["name"]["common"] ?></h4>
      </div>
      <div class="card-body">
        <img src="<?= $datos["flags"]["png"] ?>" alt="Bandera de <?= $datos["name"]["common"] ?>" class="mb-3" style="width: 150px;">
        <p><strong>Capital:</strong> <?= $datos["capital"][0] ?? 'N/D' ?></p>
        <p><strong>Poblacion:</strong> <?= number_format($datos["population"]) ?></p>
        <?php
          $moneda = array_values($datos["currencies"])[0];
          $nombreMoneda = $moneda["name"];
          $simboloMoneda = $moneda["symbol"];
        ?>
        <p><strong>Moneda:</strong> <?= "$nombreMoneda ($simboloMoneda)" ?></p>
      </div>
    </div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
