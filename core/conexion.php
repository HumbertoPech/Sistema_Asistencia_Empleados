<?php
class Conexion{
    
    private $conexion_db;
    private static $defaultInclude = false;
    public function __construct(){
        if(self::$defaultInclude){
            require_once('config/variables_DB.php');
        }else{
            require_once('../config/variables_DB.php');
        }
        
        $this->conexion_db = new mysqli(DB_HOST, DB_USUARIO, DB_CONTRA, DB_NOMBRE);
        if($this->conexion_db->connect_error){
            echo "Fallo al conectar a MySQL: "; //.$this->conexion_db->connect_error;
            return;
        }
        $this->conexion_db->set_charset(DB_CHARSET);
    }
    
    public function get_conexion(){
        return $this->conexion_db;
    }
    public function close_conexion(){
        $this->conexion_db->close();
    }
    public static function setDefaultInclude($bol){
        self::$defaultInclude = $bol;
    }
}
?>