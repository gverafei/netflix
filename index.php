<?php
    include_once( 'netflix.php' );
    $netflix = new Netflix();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/estilo.css">

    <script defer src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Netflix UV</title>
</head>
<body>    

    <nav class="nav">
        <a class="nav-link" href="index.php"><img src="images/logo.jpg" class="img-fluid"></a>
        <a class="nav-link text-white active" href="index.php">Inicio</a>
        <a class="nav-link text-white" href="peliculas.php">Películas</a>
        <a class="nav-link text-white" href="series.php">Series</a>
    </nav>

    <div class="container-fluid clearfix">
        <div class="float-end"><a class="btn btn-danger" href="nueva-pelicula.php" role="button">Nueva película</a></div>
    </div>

    <div class="container-fluid">
        <?php
        // Obtenemos las categorias
        $resultado_categorias = $netflix->categorias();
        /* obtener los valores */
        while( $categorias = $resultado_categorias->fetch_assoc() ) :
            $resultado_peliculas = $netflix->seriespeliculas_por_categoria( $categorias['idcategoria'] );
            if (mysqli_num_rows($resultado_peliculas)) : ?>
                <div class="container-fluid my-4">
                    <h4 class="font-weight-bold"><?php echo $categorias['nombre']; ?></h4>
                    <div class="row row-cols-1 row-cols-sm-3 row-cols-md-6 g-4">
                        <?php while( $peliculas = $resultado_peliculas->fetch_assoc() ) : ?>
                            <div class="col">
                                <div class="card h-100">
                                    <img src="<?php echo $peliculas['imagen']; ?>" class="card-img-top portada" title="<?php echo $peliculas['idpelicula'] . '. ' . $peliculas['titulo']; ?>">
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
    
    <div class="container-fluid text-muted text-center my-5 mb-3">
        Universidad Veracruzana <?php echo date("Y"); ?>
    </div>
</body>
</html>