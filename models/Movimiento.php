<?php 

namespace Model;

class Movimiento extends ActiveRecord{
    public static $tabla = "movimientos";
    public static $columnasDB = ["id", "nombre", "fecha", "cantidad", "tipo", "beca_id"];

    public function __construct($args = [])
    {
        $this->id = $args["id"] ?? null;
        $this->nombre = $args["nombre"] ?? "";
        $this->fecha = $args["fecha"] ?? null;
        $this->cantidad = $args["cantidad"] ?? null;
        $this->tipo = $args["tipo"] ?? "";
        $this->beca_id = $args["beca_id"] ?? null;
    }

    public function validar(){
        if(empty($this->nombre)){
            self::$alertas["error"][] = "Añade un nombre al movimiento";
        }
        if(empty($this->fecha)){
            self::$alertas["error"][] = "Añade una fecha al movimiento";
        }
        if(empty($this->cantidad)){
            self::$alertas["error"][] = "Añade una cantidad al movimiento";
        }
        if(empty($this->tipo)){
            self::$alertas["error"][] = "Añade un tipo al movimiento";
        }

        return self::$alertas;
    }
}
