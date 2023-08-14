<?php 

namespace Controllers;

use Model\Beca;
use MVC\Router;
use Model\Usuario;

class LoginController{

    public static function login(Router $router){
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarLogin();

            if(empty($alertas)){
                $usuario = Usuario::where("email", $usuario->email);

                if(!$usuario){
                    Usuario::setAlerta("error", "El Usuario no existe");
                } else{
                    // El Usuario existe
                    if(password_verify($_POST["contraseña"], $usuario->contraseña)){
                        // Iniciar Sesión
                        session_start();
                        $_SESSION["id"] = $usuario->id;
                        $_SESSION["nombre"] = $usuario->nombre;
                        $_SESSION["email"] = $usuario->email;
                        $_SESSION["login"] = true;
                        $beca = Beca::where("usuario_id", $_SESSION["id"]);
                        $_SESSION["becaId"] = $beca->id;

                        // Redireccionar
                        header("Location: /dashboard");
                        return;
                    } else{
                        Usuario::setAlerta("error", "Contraseña Incorrecta");
                    }
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render("auth/login", [
            "titulo" => "Iniciar Sesión",
            "alertas" => $alertas
        ]);
        
    }

    public static function logout(){
        if(!isset($_SESSION)){
            session_start();
        }
        $_SESSION = [];
        session_destroy();
        isAuth();
    }
}

?>