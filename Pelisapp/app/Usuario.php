<?php

class Usuario
{
    public $user;
    public $password;


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
