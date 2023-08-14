<?php 

namespace Model;

class Beca extends ActiveRecord{
    public static $tabla = "becas";
    public static $columnasDB = ["id", "becaConcedida", "becaActual", "usuario_id"];

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->becaConcedida = $args["becaConcedida"] ?? null;
        $this->becaActual = $args["becaActual"] ?? null;
        $this->usuario_id = $args["usuario_id"] ?? null;
    }

    public function validar(){
        if($this->becaConcedida < 0 || $this->becaActual < 0){
            self::setAlerta("error", "Las cantidades no pueden ser menores a 0€");
        }
        return self::getAlertas();
    }
}
