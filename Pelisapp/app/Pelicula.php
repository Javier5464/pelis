<?php
/* DATOS DE UNA PELICULA */

class Pelicula
{
   private $codigo_pelicula;
   private $nombre;
   private $director;
   private $genero;
   private $imagen;
   
   
   // Getter con método mágico
   public function __get($atributo){
       $class = get_class($this);
       if(property_exists($class, $atributo)) {
           return $this->$atributo;
       }
   }
   
   // Set con método mágico
   public function __set($atributo,$valor){
       $class = get_class($this);
       if(property_exists($class, $atributo)) {
           $this->$atributo = $valor;
       }
   }
   
}

