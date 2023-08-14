<?php 

namespace Model;

class Usuario extends ActiveRecord{
    public static $tabla = "usuarios";
    public static $columnasDB = ["id", "nombre", "email", "contraseña"];

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->contraseña = $args["contraseña"] ?? "";
    }

    public function validarLogin(){
        if(!$this->email){
            self::$alertas["error"][] = "Añada un nombre de usuario";
        }
        if(!$this->contraseña){
            self::$alertas["error"][] = "Añada su contraseña";
        } 

        return self::$alertas;
    }
}


?>