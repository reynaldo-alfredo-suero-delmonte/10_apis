<?php
$nombre = "Reynaldo Alfredo";
$apellido = "Suero Delmonte";
$foto = "foto.png";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(140, 190, 105);
            padding-top: 60px;
        }
        .info-card {
            background-color: #ca1a1a;
            color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 10px 10px 20px rgba(0,0,0,0.3);
        }
        .photo {
            border: 4px solid white;
            border-radius: 10px;
        }
        .btn-api {
            margin: 5px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="container text-center">
    <div class="info-card mx-auto mb-5" style="max-width: 600px;">
        <?php
        echo "<h1 class='mb-3'>Bienvenido</h1>
        <p><strong>NOMBRE:</strong> $nombre</p>
        <p><strong>APELLIDO:</strong> $apellido</p>
        <img src='$foto' alt='Foto de $nombre' width='250' height='300' class='photo'>";
        ?>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 justify-content-center">
        <div class="col">
            <a href="prediccion_genero.php" class="btn btn-primary btn-api">Prediccion de genero</a>
        </div>
        <div class="col">
            <a href="prediccion_edad.php" class="btn btn-success btn-api">Prediccion de edad</a>
        </div>
        <div class="col">
            <a href="universidades.php" class="btn btn-warning btn-api">Universidades de un pais</a>
        </div>
        <div class="col">
            <a href="clima.php" class="btn btn-info btn-api">El clima</a>
        </div>
        <div class="col">
            <a href="pokemon.php" class="btn btn-danger btn-api">Informacion de un pokemon</a>
        </div>
        <div class="col">
            <a href="news.html" class="btn btn-dark btn-api">Noticias sobre Wordpress</a>
        </div>
        <div class="col">
            <a href="cambio_monedas.php" class="btn btn-outline-primary btn-api">Conversion de monedas</a>
        </div>
        <div class="col">
            <a href="images.html" class="btn btn-outline-success btn-api">Generar imagenes con IA</a>
        </div>
        <div class="col">
            <a href="informacion_pais.php" class="btn btn-outline-warning btn-api">Datos de un pais</a>
        </div>
        <div class="col">
            <a href="chistes.php" class="btn btn-outline-danger btn-api">Chistes aleatorios</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
