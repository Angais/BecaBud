<?php include_once __DIR__ . "/../templates/header.php" ?>

<?php 

    // Inicializar variables
    $gastoDeuda = 0.00;
    $gastoTotal = 0.00;
    $ingresos = 0.00;

    // Recorrer el array de movimientos y sumar según tipo
    foreach ($movimientos as $movimiento) {
        $cantidad = floatval($movimiento->cantidad); // Convertir la cantidad a float

        if ($movimiento->tipo === 'deuda') {
            $gastoDeuda += $cantidad;
        }

        if ($movimiento->tipo !== 'ingreso') {
            $gastoTotal += $cantidad;
        } else {
            $ingresos += $cantidad;
        }
    }

$becaConcedida = $beca->becaConcedida;
$becaActual = $beca->becaActual;

$balanceActual = $becaActual - $gastoTotal + $ingresos;
$adeudado = $gastoDeuda;
$gastoSinDeudas = $gastoTotal - $gastoDeuda;
$becaFinalSinDeudas = $becaConcedida - $gastoSinDeudas;
$becaActualSinDeudas = $becaActual - $gastoSinDeudas;

?>


<div class="secciones">
    <div class="seccion movimientos">
        <h3>Últimos Movimientos</h2>
        <div>
<?php
    // Asegúrate de que $movimientos está definido y contiene tus datos
    if (!empty($movimientos)) {
        // Obtén los últimos 5 movimientos o menos
        $ultimosMovimientos = array_slice($movimientos, -5);

        // Recorre esos movimientos en orden inverso para mostrar del más reciente al más antiguo
        foreach (array_reverse($ultimosMovimientos) as $movimiento) {
?>
            <div class="movimiento">
                <div class="info-movimiento">
                    <a href='/movimiento?id=<?php echo $movimiento->id; ?>'><?php echo $movimiento->nombre; ?></a>
                    <p><?php 
                        $originalDate = $movimiento->fecha;
                        $date = DateTime::createFromFormat('Y-m-d', $originalDate);
                        echo $date->format('d/m/y');
                    ?>
                    </p>
                </div>
                <p>
                    <?php 
                    // Determinar el prefijo basado en el tipo de movimiento
                    $prefijo = "";
                    switch ($movimiento->tipo) {
                        case "ingreso":
                            $prefijo = "+";
                            break;
                        case "gasto":
                            $prefijo = "-";
                            break;
                        case "deuda":
                            $prefijo = "🕰️ ";  // Emoji de reloj
                            break;
                    }
                    
                    echo $prefijo . number_format($movimiento->cantidad, 2, ',', '.'); 
                    ?>€
                </p>
            </div> <!-- Fin Movimiento -->

<?php
        }
    } else {
?>
        <div class="movimiento">
            <div class="info-movimiento">
                <p>Sin movimientos</p>
                <p></p> <!-- Fecha vacía -->
            </div>
            <p>€</p> <!-- Precio vacío -->
        </div> <!-- Fin Movimiento -->

<?php
    }
?>


            <?php if(count($movimientos) > 5) {?>
            <a href="/movimientos" class="boton">Ver todos los movimientos</a>
            <?php } ?>
        </div>
    
    </div>
    <div class="seccion beca-detalle">
        <h3 class="titulo-beca">Tu beca, a detalle</h3>
        <div>
        <div class="info-beca">
            <p>Balance Actual</p>
            <p><?= number_format($balanceActual, 2, ',', '.') ?>€</p>
        </div> <!--Fin beca -->

        <div class="info-beca">
            <p>Beca Concedida</p>
            <p><?= number_format($becaConcedida, 2, ',', '.') ?>€</p>
        </div> <!--Fin beca -->

        <div class="info-beca">
            <p>Beca Actual</p>
            <p><?= number_format($becaActual, 2, ',', '.') ?>€</p>
        </div> <!--Fin beca -->

        <div class="info-beca">
            <p>Gasto Total</p>
            <p><?= number_format($gastoTotal, 2, ',', '.') ?>€</p>
        </div> <!--Fin beca -->

        <div class="info-beca">
            <p>Adeudado</p>
            <p><?= number_format($adeudado, 2, ',', '.') ?>€</p>
        </div> <!--Fin beca -->

        <div class="info-beca">
            <p>Gasto Sin Deudas</p>
            <p><?= number_format($gastoSinDeudas, 2, ',', '.') ?>€</p>
        </div> <!--Fin beca -->

        <div class="info-beca">
            <p>Beca Final sin Deudas</p>
            <p><?= number_format($becaFinalSinDeudas, 2, ',', '.') ?>€</p>
        </div> <!--Fin beca -->

        <div class="info-beca">
            <p>Beca Actual sin Deudas</p>
            <p><?= number_format($becaActualSinDeudas, 2, ',', '.') ?>€</p>
        </div> <!--Fin beca -->
        </div>
    
    </div>
</div>
<a href="/movimiento" class="boton boton-dash">Añadir Movimiento</a>
<a href="/beca" class="boton boton-dash">Editar Beca</a>