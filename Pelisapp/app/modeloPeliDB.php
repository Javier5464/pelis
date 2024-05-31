<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB
{

    private static $dbh = null;
    private static $consulta_peli = "Select * from peliculas where codigo_pelicula = ?";
    private static $delete_peli   = "Delete from peliculas where codigo_pelicula = ?";
    private  static $insert_peli  = "INSERT INTO peliculas (nombre, director, genero, imagen) VALUES (?, ?, ?, ?)";

    private static $modificar_peli =
    "UPDATE peliculas
    SET nombre = ?,
        director = ?,
        genero = ?,
        imagen = ?
    WHERE codigo_pelicula = ?";
    private static $update_peli = "UPDATE peliculas SET puntuacion = ?, numero_puntuacion = ? WHERE codigo_pelicula = ?";
    private static $valid_user = "Select * from usuarios where user = ? and password=?";



    public static function init()
    {

        if (self::$dbh == null) {
            try {
                // Cambiar  los valores de las constantes en config.php
                $dsn = "mysql:host=" . DBSERVER . ";dbname=" . DBNAME . ";charset=utf8";
                self::$dbh = new PDO($dsn, DBUSER, DBPASSWORD);
                // Si se produce un error se genera una excepción;
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Error de conexión " . $e->getMessage();
                exit();
            }
        }
    }

    public static function valid($user, $password)
    {
        $stmt = self::$dbh->prepare(self::$valid_user);
        $stmt->bindValue(1, $user);
        $stmt->bindValue(2, $password);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function update($nuevaPuntuacion, $numero_puntuacion, $codigo)
    {
        $stmt = self::$dbh->prepare(self::$update_peli);
        $stmt->bindValue(1, $nuevaPuntuacion);
        $stmt->bindValue(2, $numero_puntuacion);
        $stmt->bindValue(3, $codigo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public static function borrarPelicula($codigo)
    {
        $stmt = self::$dbh->prepare(self::$delete_peli);
        $stmt->bindValue(1, $codigo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public static function anadirPelicula($titulo, $director, $genero, $numero_puntuacionombreArchivo)
    {
        $stmt = self::$dbh->prepare(self::$insert_peli);
        $stmt->bindValue(1, $titulo);
        $stmt->bindValue(2, $director);
        $stmt->bindValue(3, $genero);
        $stmt->bindValue(4, $numero_puntuacionombreArchivo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function modificarPelicula($titulo, $director, $genero, $numero_puntuacionombreArchivo, $codigo)
    {
        $stmt = self::$dbh->prepare(self::$modificar_peli);
        $stmt->bindValue(1, $titulo);
        $stmt->bindValue(2, $director);
        $stmt->bindValue(3, $genero);
        $stmt->bindValue(4, $numero_puntuacionombreArchivo);
        $stmt->bindValue(5, $codigo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public static function GetbyTitulo($valor)
    {
        $stmt = self::$dbh->prepare(" Select * from peliculas where nombre like ?");
        $stmt->bindValue(1, $valor . "%");
        $stmt->execute();
        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ($peli = $stmt->fetch()) {
            $tpelis[] = $peli;
        }
        return $tpelis;
    }

    // Peliculas por titulo
    public static function GetbyDirector($valor)
    {
        $stmt = self::$dbh->prepare(" Select * from peliculas where director like ?");
        $stmt->bindValue(1, $valor . "%");
        $stmt->execute();
        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ($peli = $stmt->fetch()) {
            $tpelis[] = $peli;
        }
        return $tpelis;
    }

    // Peliculas por titulo
    public static function GetbyGenero($valor)
    {
        $stmt = self::$dbh->prepare(" Select * from peliculas where genero like ?");
        $stmt->bindValue(1, $valor . "%");
        $stmt->execute();
        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ($peli = $stmt->fetch()) {
            $tpelis[] = $peli;
        }
        return $tpelis;
    }


    // Tabla de objetos con todas las peliculas

    public static function GetONE($codigo)
    {
        $stmt = self::$dbh->prepare(self::$consulta_peli);
        $stmt->bindValue(1, $codigo);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        $stmt->execute();
        $peli = $stmt->fetch();
        return $peli;
    }


    public static function GetAll(): array
    {


        $stmt = self::$dbh->query("select * from peliculas");

        $tpelis = [];
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
        while ($peli = $stmt->fetch()) {
            $tpelis[] = $peli;
        }
        return $tpelis;
    }

    public static function closeDB()
    {
        self::$dbh = null;
    }
}
