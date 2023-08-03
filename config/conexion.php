<?php
// Iniciamos la sesion del usuario con session start
session_start();


// Creamos la clase Conectar y una variable protegida dbh : dbhost 

class Conectar
{
    protected $dbh;

    protected function Conexion()
    {
        // Abrimos un Try catch en caso de que exista problemas de conexion 

        try {
            // Cadena de Conexion Local para  establecer la conexion a la base de datos llamada helpdesk. El usuario de la db  y la contraseña.
            //$conectar = $this->dbh = new PDO("mysql:local=localhost;dbname=helpdesk","root","");
            //todo Conexion desde notebook:
            $conectar = $this->dbh = new PDO("mysql:local=localhost;port=3306;dbname=helpdesk", "root", "");
            return $conectar;
        } catch (Exception $e) {
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    // Agregamos una funcion para que no exista problemas con las tildes y ñ  
    public function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8'");
    }

    // Luego validamos la ruta del Proyecto
    public static function ruta()
    {
        return "http://localhost:80/helpdesk/";
    }
}
?>