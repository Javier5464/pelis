<?php

session_start();
include_once 'app/config.php';
include_once 'app/controlerPeli.php';
include_once 'app/modeloPeliDB.php';

// Inicializo el modelo 
ModeloPeliDB::Init();


// Enrutamiento
// Relación entre peticiones y función que la va a tratar
// Versión sin POO no manejo de Clases ni objetos
// Rutas en MODO PELICULAS
$rutasPelis = [
    "Inicio"      => "ctlPeliInicio",
    "Alta"        => "ctlPeliAlta",
    "Detalles"    => "ctlPeliDetalles",
    "Modificar"   => "ctlPeliModificar",
    "Borrar"      => "ctlPeliBorrar",
    "Cerrar"      => "ctlPeliCerrar",
    "VerPelis"    => "ctlPeliVerPelis",
    "Buscar Título"   => "ctlBuscaTitulo",
    "Buscar Genero"   => "ctlBuscaGenero",
    "Buscar Director" => "ctlBuscaDirector",
    "DescargarJSON" => "ctlDescargarJSON",
    "Login" => "ctlLogin",
    "Puntuacion" => "ctlPuntuacion",
    "Logout" => "ctlLogout"
];


if (isset($_GET['orden'])) {
    // La orden tiene una funcion asociada 
    if (isset($rutasPelis[$_GET['orden']])) {
        $procRuta =  $rutasPelis[$_GET['orden']];
    } else {
        // Error no existe función para la ruta
        header('Status: 404 Not Found');
        echo '<html><body><h1>Error 404: No existe la ruta <i>' .
            $_GET['ctl'] .
            '</p></body></html>';
        exit;
    }
} else {
    $procRuta = "ctlPeliVerPelis";
}


// La salida se guarda en buffer
ob_start();
// Llamo a la función seleccionada que puede llamar a una vista
$procRuta();
// Vacio el buffer y lo copio a contenido
// Para que se muestre en div de contenido
$contenido = ob_get_clean();
include_once "app/plantilla/principal.php";
