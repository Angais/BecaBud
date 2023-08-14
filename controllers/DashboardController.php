<?php 

namespace Controllers;

use Model\Beca;
use Model\Movimiento;
use MVC\Router;

class DashboardController{

    public static function index(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();
        $beca = Beca::where("usuario_id", $_SESSION["id"]);
        $movimientos = Movimiento::whereAll("beca_id", $beca->id);

        $router->render("dashboard/dashboard", [
            "titulo" => "Menú Principal",
            "beca" => $beca,
            "movimientos" => $movimientos
        ]);
    }

    public static function movimientos(Router $router){

        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();

        function filtrarMovimientosPorNombreFecha($movimientos, $buscar, $fecha) {
            return array_filter($movimientos, function ($movimiento) use ($buscar, $fecha) {
                $nombreNormalizado = mb_strtolower(normalizarTexto($movimiento->nombre));
                $buscarNormalizado = mb_strtolower(normalizarTexto(trim($buscar))); // Aquí utilizamos trim()
        
                $coincideNombre = !empty($buscarNormalizado) && strpos($nombreNormalizado, $buscarNormalizado) !== false;
                $coincideFecha = !empty($fecha) && $movimiento->fecha === $fecha;
        
                if (!empty($buscarNormalizado) && !empty($fecha)) {
                    return $coincideNombre && $coincideFecha;
                } elseif (!empty($buscarNormalizado)) { // Aquí también cambiamos a $buscarNormalizado
                    return $coincideNombre;
                } elseif (!empty($fecha)) {
                    return $coincideFecha;
                }
        
                return true;
            });
        }
        
        function normalizarTexto($string) {
            $unwanted_array = array(
                'Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 
                'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 
                'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 
                'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 
                'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 
                'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 
                'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 
                'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 
                'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 
                'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 
                'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'
            );
        
            return strtr($string, $unwanted_array);
        }

        $movimientos = Movimiento::whereAll("beca_id", $_SESSION["becaId"]);


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $buscar = $_POST['buscar'] ?? "";
            $fecha = $_POST['fecha'] ?? "";
        
            $movimientos = filtrarMovimientosPorNombreFecha($movimientos, $buscar, $fecha);
        }

        $router->render("dashboard/movimientos", [
            "titulo" => "Todos los Movimientos",
            "movimientos" => $movimientos
        ]);


        
    }

    public static function editar(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();
        $movimiento = [];
        $alertas = [];
        if(!empty($_GET)){
            
            if(isset($_GET["eliminar"])){
                
                $movimiento = Movimiento::where("id", $_GET["eliminar"]);
                
                if($movimiento && $movimiento->beca_id === $_SESSION["becaId"]){
                    $movimiento->eliminar();
                    header("Location: /dashboard");
                    return;
                } else{
                    header("Location: /dashboard");
                    return;
                }
            }
            $nombre = "Editar Movimiento";
            $movimiento = Movimiento::where("id", $_GET["id"]);
            if(!$movimiento || $movimiento->beca_id !== $_SESSION["becaId"]){
                header("Location: /dashboard");
                return;
            }
            $movimiento->sincronizar($_POST);


        } else{
            $nombre = "Añadir Movimiento";

            if($_SERVER["REQUEST_METHOD"] === "POST"){
                $movimiento = new Movimiento($_POST);
                
            }
        }

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $alertas = $movimiento->validar();
            if(empty($alertas)){
                $movimiento->beca_id = $_SESSION["becaId"];
                $movimiento->guardar();
                $movimiento->setAlerta("exito", "Guardado");
            }
            $alertas = $movimiento->getAlertas();
        }


        $router->render("dashboard/editar-añadir", [
            "titulo" => $nombre,
            "movimiento" => $movimiento,
            "alertas" => $alertas
        ]);
    }

    public static function beca(Router $router){
        if(!isset($_SESSION)){
            session_start();
        }
        isAuth();
        $alertas = [];

        $beca = Beca::where("id", $_SESSION["becaId"]);
        if(!isset($beca)){
            header("Location: /dashboard");
            return;
        }

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $beca->sincronizar($_POST);
            $alertas = $beca->validar();

            if(empty($errores)){
                $beca->guardar();
                header("Location: /dashboard");
                return;
            }

        }

        $router->render("dashboard/beca", [
            "titulo" => "Editar Beca",
            "beca" => $beca,
            "alertas" => $alertas
        ]);
    }
}

?>