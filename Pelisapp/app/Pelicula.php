<?php
/* DATOS DE UNA PELICULA */

class Pelicula
{
    public $codigo_pelicula;
    public $nombre;
    public $director;
    public $genero;
    public  $imagen;
    public  $puntuacion;
    public  $numero_puntuacion;


    // Getter con método mágico
    public function __get($atributo)
    {
        $class = get_class($this);
        if (property_exists($class, $atributo)) {
            return $this->$atributo;
        }
    }

    // Set con método mágico
    public function __set($atributo, $valor)
    {
        $class = get_class($this);
        if (property_exists($class, $atributo)) {
            $this->$atributo = $valor;
        }
    }
}
