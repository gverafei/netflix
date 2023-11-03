<?php

class Netflix {

    static $mysqli;
    static $uploads = 'uploads/';
	
	public function __construct()
    {        
        self::conectar();
    }

    function __destruct() {
        self::desconectar();
    }

    protected function conectar()
    {
        self::$mysqli = new mysqli( 'localhost', 'netflix_user', 'N3tfl1x', 'netflix' );
        if ( self::$mysqli->connect_error ) {
            die( 'Error de Conexión (' . self::$mysqli->connect_errno . ') ' . self::$mysqli->connect_error );
        }
    }

    protected function desconectar()
    {
        self::$mysqli->close();
    }

    public function seriespeliculas_por_categoria( $idcategoria )
    {
        $resultado = null;
        $consulta = "SELECT pelicula.idpelicula, titulo, imagen FROM pelicula, pelicula_categoria WHERE pelicula.idpelicula = pelicula_categoria.idpelicula AND idcategoria = ?";

        if ( $sentencia = self::$mysqli->prepare( $consulta ) ) {

            /* ligar parámetros para marcadores */
            $sentencia->bind_param( "s", $idcategoria );

            /* ejecutar la sentencia */
            $sentencia->execute();

            $resultado = $sentencia->get_result();
            $sentencia->close();
        }

        return $resultado;
    }

    public function peliculas_por_categoria( $idcategoria )
    {
        $resultado = null;
        $consulta = "SELECT pelicula.idpelicula, titulo, imagen FROM pelicula, pelicula_categoria WHERE pelicula.idpelicula = pelicula_categoria.idpelicula AND idcategoria = ? AND pelicula.idtipo = 1";

        if ( $sentencia = self::$mysqli->prepare( $consulta ) ) {

            /* ligar parámetros para marcadores */
            $sentencia->bind_param( "s", $idcategoria );

            /* ejecutar la sentencia */
            $sentencia->execute();

            $resultado = $sentencia->get_result();
            $sentencia->close();
        }

        return $resultado;
    }

    public function series_por_categoria( $idcategoria )
    {
        $resultado = null;
        $consulta = "SELECT pelicula.idpelicula, titulo, imagen FROM pelicula, pelicula_categoria WHERE pelicula.idpelicula = pelicula_categoria.idpelicula AND idcategoria = ? AND pelicula.idtipo = 2";

        if ( $sentencia = self::$mysqli->prepare( $consulta ) ) {

            /* ligar parámetros para marcadores */
            $sentencia->bind_param( "s", $idcategoria );

            /* ejecutar la sentencia */
            $sentencia->execute();

            $resultado = $sentencia->get_result();
            $sentencia->close();
        }

        return $resultado;
    }

    public function categorias()
    {
        $resultado = null;
        $consulta = 'SELECT idcategoria, nombre FROM categoria';

        if ( $sentencia = self::$mysqli->prepare( $consulta ) ) {
            $sentencia->execute();
            
            $resultado = $sentencia->get_result();
            $sentencia->close();
        }

        return $resultado;
    }

    public function tipos()
    {
        $resultado = null;
        $consulta = 'SELECT idtipo, nombre FROM tipo';

        if ( $sentencia = self::$mysqli->prepare( $consulta ) ) {
            $sentencia->execute();
            
            $resultado = $sentencia->get_result();
            $sentencia->close();
        }

        return $resultado;
    }

    public function nueva_pelicula()
    {
        $http_post = ( 'POST' == $_SERVER['REQUEST_METHOD'] );	
    
        if ( $http_post ) {            
            $titulo = htmlspecialchars( $_POST['titulo'], ENT_QUOTES );
            $idtipo = htmlspecialchars( $_POST['tipo'], ENT_QUOTES );
            $categoria = filter_input( INPUT_POST, 'categoria', FILTER_DEFAULT , FILTER_REQUIRE_ARRAY );
    
            // Se verifica que vengan los campos
            if ( empty( $titulo ) || empty( $idtipo ) || empty( $categoria ) )
            {
                return "Debes proporcionar todos los campos.";
            }

            $target_file = self::$uploads . basename( $_FILES["portada"]["name"] );
            $imageFileType = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );

            // Solo permite archivos jpg, png, jpeg, gif
            if( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                return "Solo se permiten las extensiones JPG, PNG, JPEG y GIF.";
            }

            // Verifica si existe el archivo
            if ( !file_exists( $target_file ) ) {
                if ( !move_uploaded_file( $_FILES["portada"]["tmp_name"], $target_file ) ) {
                    return "Ocurrió un error al subir el archivo.";
                }
            }

            // Inserta los datos de pelicula
            $consulta = "INSERT INTO pelicula(titulo, idtipo, imagen) VALUES (?,?,?)";
            if ( $sentencia = self::$mysqli->prepare( $consulta ) ) {
                $sentencia->bind_param( "sis", $titulo, $idtipo, $target_file );
                $sentencia->execute();
                $idpelicula = self::$mysqli->insert_id;
                $sentencia->close();
            }

            // Inserta los datos de categorias
            foreach( $_POST['categoria'] as $idcategoria ) {
                $consulta = "INSERT INTO pelicula_categoria(idpelicula, idcategoria) VALUES (?,?)";
                if ( $sentencia = self::$mysqli->prepare( $consulta ) ) {
                    $sentencia->bind_param( "ii", $idpelicula, $idcategoria );
                    $sentencia->execute();
                    $sentencia->close();
                }
            }
            
            // Todo salió bien
            return true;
        }
    }
}

?>