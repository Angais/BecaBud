<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use MVC\Router;
use Controllers\LoginController;
$router = new Router();



$router->get("/logout", [LoginController::class, "logout"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);

$router->get("/dashboard", [DashboardController::class, "index"]);
$router->get("/movimientos", [DashboardController::class, "movimientos"]);
$router->post("/movimientos", [DashboardController::class, "movimientos"]);
$router->get("/movimiento", [DashboardController::class, "editar"]);
$router->post("/movimiento", [DashboardController::class, "editar"]);
$router->get("/beca", [DashboardController::class, "beca"]);
$router->post("/beca", [DashboardController::class, "beca"]);


$router->comprobarRutas();
