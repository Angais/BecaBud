<?php include_once __DIR__ . "/../templates/header.php" ?>
<h3 class="titulo"><?php if(isset($movimiento->nombre) && trim($movimiento->nombre) > 0){echo $movimiento->nombre;} else{echo "Añadir Movimiento";}?></h3>
<div class="contenedor-sm">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <form class="formulario" method="POST">
        <div class="campo">
            <input type="text" name="nombre" id="nombre" placeholder="Nombre del Movimiento" value='<?php echo $movimiento->nombre ?? "" ?>'>
        </div>

        <div class="campo">
            <input type="date" name="fecha" id="fecha" placeholder="Fecha del Movimiento" value='<?php echo $movimiento->fecha ?? date("Y-m-d") ?>'>
        </div>

        <div class="campo">
            <input type="number" step="0.01" name="cantidad" id="cantidad" placeholder="Cantidad en € del Movimiento" value='<?php echo $movimiento->cantidad ?? "" ?>' min=0 max=10000>
        </div>
        <div class="campo">
            <select name="tipo" id="tipo_movimiento">
                <option value="gasto" <?php echo (isset($movimiento->tipo) && $movimiento->tipo == 'gasto') ? 'selected' : ''; ?>>Gasto</option>
                <option value="ingreso" <?php echo (isset($movimiento->tipo) && $movimiento->tipo == 'ingreso') ? 'selected' : ''; ?>>Ingreso</option>
                <option value="deuda" <?php echo (isset($movimiento->tipo) && $movimiento->tipo == 'deuda') ? 'selected' : ''; ?>>Deuda</option>
            </select>
        </div>



        <input type="submit" value="Guardar" class="boton boton-2">
        <?php if(isset($movimiento->id)){ ?>
            <a href="/movimiento?eliminar=<?php echo $movimiento->id ?>" class="eliminar">Eliminar</a>
        <?php } ?>

    </form>
</div>