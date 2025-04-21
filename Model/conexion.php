<?php
class conexion {
    public $host = "localhost";
    public $database = "crud_aprendices";
    public $user = "root";
    public $password = "";
    public $conexion;

    public function __construct() {
        try {
            $this->conexion = new PDO(
                "mysql:host=$this->host;dbname=$this->database;charset=utf8",
                $this->user,
                $this->password
            );
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function conectado() {
        return $this->conexion;
    }
}
