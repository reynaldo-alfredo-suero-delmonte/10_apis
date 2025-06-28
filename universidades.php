<?php
$pais = "";
$universidades = [];
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pais = trim($_POST["pais"]);
    $url = "http://universities.hipolabs.com/search?country=" . urlencode($pais);
    $respuesta = @file_get_contents($url);

    if ($respuesta !== false) {
        $datos = json_decode($respuesta, true);
        if (!empty($datos)) {
            $universidades = $datos;
        } else {
            $error = "No se encontraron universidades";
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
  <title>Universidades</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-dark bg-warning">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Volver al inicio</a>
  </div>
</nav>

<main class="container mt-5">
  <h2 class="text-center mb-4">Universidades por pais</h2>

  <form method="POST" action="" class="mb-4">
    <div class="mb-3">
      <label for="pais" class="form-label">Ingresa el pais en ingles:</label>
      <input type="text" class="form-control" id="pais" name="pais" value="<?= htmlspecialchars($pais) ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Buscar</button>
  </form>

  <?php if (!empty($universidades)): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>Nombre</th>
            <th>Dominio</th>
            <th>Enlace</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($universidades as $uni): ?>
            <tr>
              <td><?= htmlspecialchars($uni['name']) ?></td>
              <td><?= htmlspecialchars($uni['domains'][0]) ?></td>
              <td><a href="<?= htmlspecialchars($uni['web_pages'][0]) ?>" target="_blank">Visitar</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
