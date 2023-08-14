<?php
date_default_timezone_set('Europe/Madrid');
function fechaEnEspanol($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $meses = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $dia = $dias[date('w', strtotime($fecha))];
    $mes = $meses[date('n', strtotime($fecha)) - 1];

    return $dia . ", " . date('d', strtotime($fecha)) . " de " . $mes . " de " . date('Y', strtotime($fecha));
}

$fechaActual = fechaEnEspanol(date("Y-m-d"));

// Cambio del saludo basado en la hora
$horaActual = intval(date("H"));
$saludo = "Buenas";

if ($horaActual >= 6 && $horaActual < 12) {
    $saludo = "Buenos días";
} elseif ($horaActual >= 12 && $horaActual < 21) {
    $saludo = "Buenas tardes";
} else {
    $saludo = "Buenas noches";
}
?>

<div class="header">
    <div class="contenedor-header">
        <a href="/dashboard" class="info"><?php echo $saludo . ", " . $_SESSION["nombre"]; ?></a>
        <div class="header-otros">
            <p class="info"><?php echo $fechaActual; ?></p>
            <a href="/logout" class="boton">Cerrar Sesión</a>
        </div>
    </div>
</div>
