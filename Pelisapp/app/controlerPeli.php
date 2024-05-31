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
function  ctlPeliInicio()
{
    die(" No implementado.");
    //no se implementa de momento
}


function ctlPeliAlta()
{
    if (isset($_SESSION["usuario"])) {
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
                header('Location: index.php');
            } else {
                $_SESSION["msg"] = "Rellene todos los campos.";
            }
        }
    } else {
        $_SESSION["msg"] = "Tienes que estar registrado para poder dar de alta una pelicula";
        ctlPeliVerPelis();
    }
}

function ctlPuntuacion()
{
    if (!empty($_GET['codigo']) && !empty($_GET['Puntuacion'])) {
        if (isset($_COOKIE['usertoken'])) {

            $conteoVotos = isset($_COOKIE['conteoVotos']) ? (int)$_COOKIE['conteoVotos'] : 0;

            if ($conteoVotos < 5) {
                $codigo = $_GET["codigo"];
                $peli = ModeloPeliDB::GetOne($codigo);
                $puntuacion = (int)$_GET['Puntuacion'];
                $numero_puntuacion = $peli->numero_puntuacion + 1;
                $nuevaPuntuacion = $peli->puntuacion + $puntuacion;

                ModeloPeliDB::update($nuevaPuntuacion, $numero_puntuacion, $codigo);

                $conteoVotos++;
                setcookie('conteoVotos', $conteoVotos, time() + 24 * 60 * 60);

                ctlPeliDetalles();
            } else {
                $_SESSION["msg"] = "Solo puedes puntuar 5 veces al día";
                ctlPeliDetalles();
            }
        }
    }
}



function ctlLogin()
{
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $user = $_POST['user'];
        $password = $_POST['password'];
        $resultado = ModeloPeliDB::valid($user, $password);
        if ($resultado) {
            $_SESSION["msg"] = $user;
            $_SESSION["usuario"] = $user;

            setcookie('usertoken', $user, time() + 24 * 60 * 60);
            setcookie('conteoVotos', 0, time() + 24 * 60 * 60);

            ctlPeliVerPelis();
        } else {
            $_SESSION["msg"] = "Las credenciales son incorrectas";
            include_once 'plantilla/login.php';
        }
    } else {
        include_once 'plantilla/login.php';
    }
}


function ctlLogout()
{
    session_destroy();
    session_start();
    $_SESSION["msg"] = "Ha cerrado sesión";
    header("Location: index.php?orden=VerPelis");
    exit();
}



function ctlBuscaTitulo()
{
    if (!empty($_GET['valor'])) {
        $valor = $_GET['valor'];
        $peliculas = ModeloPeliDB::GetbyTitulo($valor);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlBuscaDirector()
{
    if (!empty($_GET['valor'])) {
        $valor = $_GET['valor'];
        $peliculas = ModeloPeliDB::GetbyDirector($valor);
        include_once 'plantilla/verpeliculas.php';
    }
}

function ctlBuscaGenero()
{
    if (!empty($_GET['valor'])) {
        $valor = $_GET['valor'];
        $peliculas = ModeloPeliDB::GetbyGenero($valor);
        include_once 'plantilla/verpeliculas.php';
    }
}



function ctlPeliModificar()
{
    if (isset($_GET['codigo'])) {
        if (isset($_SESSION["usuario"])) {
            $_SESSION["msg"];
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
        } else {
            $_SESSION["msg"] = "Tienes que estar registrado para poder editar una pelicula";
            ctlPeliVerPelis();
        }
    }
}
/*
* Muestra detalles de la pelicula
*/
function ctlPeliDetalles()
{
    if (isset($_GET['codigo'])) {
        $codigo = $_GET['codigo'];
        $peli = ModeloPeliDB::GetOne($codigo);
        $_SESSION["msg"];
        include_once 'plantilla/detalle.php';
    }
}

function buscarPosterOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Poster'])) {
            return $json['Poster'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarPlotOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Plot'])) {
            return $json['Plot'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarWriterOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Writer'])) {
            return $json['Writer'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarActorsOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Actors'])) {
            return $json['Actors'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarYearOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Year'])) {
            return $json['Year'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarCountryOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Country'])) {
            return $json['Country'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarAwardsOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Awards'])) {
            return $json['Awards'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarRatingsOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Ratings'])) {
            return $json['Ratings'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarMetascoreOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['Metascore'])) {
            return $json['Metascore'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function buscarImdbRatingOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['imdbRating'])) {
            return $json['imdbRating'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}
function buscarBoxOfficeOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['BoxOffice'])) {
            return $json['BoxOffice'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}
function buscarimdbIDOMDB($nombrePelicula)
{
    $apiKey = '83a2b83f';
    $query = urlencode($nombrePelicula);
    $url = "http://www.omdbapi.com/?t=$query&apikey=$apiKey";

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if (isset($json['Response']) && $json['Response'] == 'True') {
        if (isset($json['imdbID'])) {
            return $json['imdbID'];
        } else {
            return null;
        }
    } else {
        return null;
    }
}


/*
* Borrar Peliculas
*/
function ctlPeliBorrar()
{

    if (isset($_GET['codigo'])) {
        if (isset($_SESSION["usuario"])) {
            $_SESSION["msg"] = "La pelicula ha sido eliminada";
            $codigo = $_GET["codigo"];
            ModeloPeliDB::borrarPelicula($codigo);
            ctlPeliVerPelis();
        } else {
            ctlPeliVerPelis();
            $_SESSION["msg"] = "Tienes que estar registrado para poder borrar una pelicula";
        }
    }
}

function ctlDescargarJSON()
{
    $peliculas = ModeloPeliDB::GetAll();
    $json = json_encode($peliculas);
    header("Content-Type: application/json");
    echo $json;
    // 3) Por defecto solo se muestras los atributos público --> Cambiar la clases Pelicula     
    exit();
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

function ctlPeliVerDetalles()
{
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAll();
    // Invoco la vista
    include_once 'plantilla/detalle.php';
}
