<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php';

/**********
/*
 * Inicio Muestra o procesa el formulario (POST)
 */
$mensaje = $_SESSION["msg"];
function  ctlPeliInicio()
{
    die(" No implementado.");
    //no se implementa de momento
}



/*
 *  Muestra y procesa el formulario de alta 
 */

function ctlPeliAlta()
{
    include_once 'plantilla/alta.php';
    if (!empty($_POST['Titulo']) && !empty($_POST['Director']) && !empty($_POST['Genero'] && !empty($_FILES['imagen']['name']))) {

        $titulo = $_POST['Titulo'];
        $director = $_POST['Director'];
        $genero = $_POST['Genero'];
        $nombreArchivo = "";
        if (!empty($_FILES['imagen']['name'])) {
            $destino = realpath('app/img/') . '/';
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);


            if (in_array($ext, ['jpg', 'png'])) {
                $nombreArchivo = 'imagen' . '.' . $ext;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $destino . $nombreArchivo);
            } else {
                $_SESSION["msg"] = "Solo se pueden subir archivos jpg y png.";
            }
        }
        if (ModeloPeliDB::anadirPelicula($titulo, $director, $genero, $nombreArchivo)) {
            $_SESSION["msg"] = "Se ha añadido la película.";
            ctlPeliVerPelis();
        }
    } else {
        $_SESSION["msg"] = "Rellene todos los campos.";
    }
}


function ctlPeliBuscar()
{
    if (isset($_GET['a'])) {
        $a = $_GET["a"];
        $orden = $_GET["orden"];
        $x = "";

        switch ($orden) {
            case "Titulo":
                $x = "nombre";
                break;
            case "Director":
                $x = "director";
                break;
            case "Genero":
                $x = "genero";
                break;
        }

        $resultados = ModeloPeliDB::buscarPelicula($x, $a);
        var_dump($resultados);
        if (!empty($resultados)) {
            echo '<table border="1">';
            echo '<tr><th>Título</th><th>Director</th><th>Género</th></tr>';
            foreach ($resultados as $resultado) {
                echo '<tr>';
                echo '<td>' . $resultado['nombre'] . '</td>';
                echo '<td>' . $resultado['director'] . '</td>';
                echo '<td>' . $resultado['genero'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No se encontraron resultados.';
        }
    }
}








function ctlPeliModificar()
{
    if (isset($_GET['codigo'])) {
        $codigo = $_GET["codigo"];
        $peli = ModeloPeliDB::GetOne($codigo);
        $nombreArchivo = "";

        if (!empty($_FILES['imagen']['name'])) {
            $destino = realpath('app/img/') . '/';
            $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);


            if (in_array($ext, ['jpg', 'png'])) {
                $nombreArchivo = 'imagen' . '.' . $ext;
                move_uploaded_file($_FILES['imagen']['tmp_name'], $destino . $nombreArchivo);
            } else {
                $_SESSION["msg"] = "Solo se pueden subir archivos jpg y png.";
            }
        }
        if (empty($_SESSION["msg"])) {
            $titulo = isset($_POST['Titulo']) ? $_POST['Titulo'] : '';
            $director = isset($_POST['Director']) ? $_POST['Director'] : '';
            $genero = isset($_POST['Genero']) ? $_POST['Genero'] : '';


            if (!empty($titulo) || !empty($director) || !empty($genero) || !empty($nombreArchivo)) {

                ModeloPeliDB::modificarPelicula($titulo, $director, $genero, $nombreArchivo, $codigo);
                $_SESSION["msg"] = "Se ha editado la película.";
                ctlPeliVerPelis();
            } else {
                include_once 'plantilla/modificacion.php';
            }
        }
    }
}










/*
 *  Muestra detalles de la pelicula
 */
function ctlPeliDetalles()
{
    if (isset($_GET['codigo'])) {
        $codigo = $_GET["codigo"];
        $peli = ModeloPeliDB::GetOne($codigo);
        include_once 'plantilla/detalle.php';
    }
}

/*
 * Borrar Peliculas
 */
function ctlPeliBorrar()
{

    if (isset($_GET['codigo'])) {
        $codigo = $_GET["codigo"];
        ModeloPeliDB::borrarPelicula($codigo);
        $_SESSION["msg"] = "La pelicula ha sido eliminada";
        ctlPeliVerPelis();
    }
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar()
{
    session_destroy();
    modeloPeliDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */
function ctlPeliVerPelis()
{
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAll();
    // Invoco la vista 
    include_once 'plantilla/verpeliculas.php';
}
