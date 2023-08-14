<?php include_once __DIR__ . "/../templates/header.php" ?>
<h3 class="titulo">Tus Movimientos</h3>

<div class="listado-movimientos">
    <form action="/movimientos" class="formulario" method="POST">
        <div class="campo">
            <input type="text" name="buscar" id="buscar" placeholder="Buscar por nombre" value="<?php echo isset($_POST['buscar']) ? htmlspecialchars($_POST['buscar']) : ''; ?>">
        </div>

        <div class="campo">
            <input type="date" name="fecha" id="fecha" placeholder="Buscar por fecha">
        </div>
        <input type="submit" value="Buscar" class="boton">

    </form>
<?php
            // Asegúrate de que $movimientos está definido y contiene tus datos
            if (!empty($movimientos)) {
                // Recorre esos movimientos en orden inverso para mostrar del más reciente al más antiguo
                foreach (array_reverse($movimientos) as $movimiento) {
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
            }
            ?>
            <a href="/movimiento" class="boton">Añadir Movimiento</a>
</div>