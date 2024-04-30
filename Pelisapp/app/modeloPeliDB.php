<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB
{

    private static $dbh = null;
    private static $consulta_peli = "Select * from peliculas where codigo_pelicula = ?";
    private static $delete_peli   = "Delete from peliculas where codigo_pelicula = ?";
    private  static $insert_peli  = "INSERT INTO peliculas (nombre, director, genero, imagen) VALUES (?, ?, ?, ?)"; //comentar autoincrement
    private  static $search_peli = "SELECT * FROM peliculas WHERE ? LIKE '?'";
    private static $modificar_peli =
    "UPDATE peliculas
    SET nombre = ?,
        director = ?,
        genero = ?,
        imagen = ?
    WHERE codigo_pelicula = ?";


    /*private  static $delete_user   = "Insert into peliculas (codigo_pelicula, nombre, director, genero)" .
        " VALUES (?,?,?,?)";
    private static $update_user    = "UPDATE Usuarios set  clave=?, nombre =?, " .
        "email=?, plan=?, estado=? where id =?";
    */


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

    public static function buscarPelicula($x, $a)
    {
        $stmt = self::$dbh->prepare(self::$search_peli);
        $stmt->bindValue(1, $x);
        $stmt->bindValue(2, $a);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultados;
    }





    public static function anadirPelicula($titulo, $director, $genero, $nombreArchivo)
    {
        $stmt = self::$dbh->prepare(self::$insert_peli);
        $stmt->bindValue(1, $titulo);
        $stmt->bindValue(2, $director);
        $stmt->bindValue(3, $genero);
        $stmt->bindValue(4, $nombreArchivo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function modificarPelicula($titulo, $director, $genero, $nombreArchivo, $codigo)
    {
        $stmt = self::$dbh->prepare(self::$modificar_peli);
        $stmt->bindValue(1, $titulo);
        $stmt->bindValue(2, $director);
        $stmt->bindValue(3, $genero);
        $stmt->bindValue(4, $nombreArchivo);
        $stmt->bindValue(5, $codigo);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }



    //Borrar un usuario (boolean)
    /*public static function UserDel($userid)
    {
        $stmt = self::$dbh->prepare(self::$delete_user);
        $stmt->bindValue(1, $userid);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }
  
    //Añadir un nuevo usuario (boolean)
    /*public static function UserAdd($userid, $userdat): bool
    {
        $stmt = self::$dbh->prepare(self::$insert_user);
        $stmt->bindValue(1, $userid);
        $clave = Cifrador::cifrar($userdat[0]);
        $stmt->bindValue(2, $clave);
        $stmt->bindValue(3, $userdat[1]);
        $stmt->bindValue(4, $userdat[2]);
        $stmt->bindValue(5, $userdat[3]);
        $stmt->bindValue(6, $userdat[4]);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
      */


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
