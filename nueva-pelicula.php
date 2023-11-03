<?php
include_once('netflix.php');
$netflix = new Netflix();

// Se ejecuta cuando se envía el formulario
$respuesta = $netflix->nueva_pelicula();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.ico">

    <link rel="shortcut icon" href="images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/estilo.css">

    <script defer src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script defer src="js/nueva-pelicula.js"></script>
    <title>Netflix UV</title>
</head>

<body>
    <nav class="nav">
        <a class="nav-link" href="index.php"><img src="images/logo.jpg" class="img-fluid"></a>
        <a class="nav-link text-white active" href="index.php">Inicio</a>
        <a class="nav-link text-white" href="peliculas.php">Películas</a>
        <a class="nav-link text-white" href="series.php">Series</a>
    </nav>

    <div class="container">
        <?php
        if ($respuesta === true) : ?>
            <div class="h-100 p-5 text-bg-dark rounded-3">
                <h2>Pélicula</h2>
                <p>La película fue agregada con éxito.</p>
                <a class="btn btn-danger btn-lg" href="index.php" role="button">Página principal</a>
            </div>
        <?php else : ?>
            <h4 class="font-weight-bold">Nueva película</h4>
            <?php if (!empty($respuesta)) : ?>
                <div class="alert alert-danger" role="alert"><?php echo $respuesta; ?></div>
            <?php endif; ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Título:</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título">
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo:</label>
                    <select class="form-control" id="tipo" name="tipo">
                        <?php
                        $resultado_tipos = $netflix->tipos();
                        while ($tipos = $resultado_tipos->fetch_assoc()) : ?>
                            <option value="<?php echo $tipos['idtipo']; ?>"><?php echo $tipos['nombre']; ?></option>
                        <?php endwhile;
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Categoría:</label>
                    <?php
                    $resultado_categorias = $netflix->categorias();
                    while ($categorias = $resultado_categorias->fetch_assoc()) : ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox<?php echo $categorias['idcategoria']; ?>" name="categoria[]" value="<?php echo $categorias['idcategoria']; ?>">
                            <label class="form-check-label" for="inlineCheckbox<?php echo $categorias['idcategoria']; ?>"><?php echo $categorias['nombre']; ?></label>
                        </div>
                    <?php endwhile;
                    ?>
                </div>
                <div class="mb-3">
                    <label for="portada" class="form-label">Seleccionar portada</label>
                    <input class="form-control" type="file" id="portada" name="portada">
                </div>
                <button type="submit" class="btn btn-danger mt-4">Crear película</button>
            </form>
        <?php endif; ?>
    </div>

    <div class="container-fluid text-muted text-center my-5 mb-3">
        Universidad Veracruzana <?php echo date("Y"); ?>
    </div>
</body>

</html>