<?php

session_start();
$_SESSION['msg'] = "";

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
    "Alta"        => "ctlPeliAlta",  //anadir peli
    "Detalles"    => "ctlPeliDetalles",     //detalle.php
    "Modificar"   => "ctlPeliModificar",        //modificar peli
    "Borrar"      => "ctlPeliBorrar",            //borrar peli
    "Cerrar"      => "ctlPeliCerrar",
    "VerPelis"    => "ctlPeliVerPelis",
    "Buscar"      => "ctlPeliBuscar",
    "Titulo"      => "ctlPeliBuscar",
    "Director"    => "ctlPeliBuscar",
    "Genero"      => "ctlPeliBuscar",
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


// Envio la salida al buffer
ob_start();
// Llamo a la función seleccionada
$procRuta();
// Vacio el bufer y lo copio a contenido
// Para que se muestre en div de contenido la página principal
$contenido = ob_get_clean();
$mensaje = $_SESSION["msg"];
include_once "app/plantilla/principal.php";
