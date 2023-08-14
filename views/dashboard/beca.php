<?php include_once __DIR__ . "/../templates/header.php" ?>
<h3 class="titulo">Editar Beca</h3>
<div class="contenedor-sm">
    <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
    <form class="formulario" method="POST">
        <div class="campo">
            <input type="number" step="0.01" name="becaConcedida" id="becaConcedida" placeholder="Cantidad en € de tu Beca Concedida" value='<?php echo $beca->becaConcedida; ?>'  min=0 max=10000>
        </div>

        <div class="campo">
            <input type="number" step="0.01" name="becaActual" id="becaActual" placeholder="Cantidad en € de tu beca Actual" value='<?php echo $beca->becaActual; ?>' min=0 max=10000>
        </div>

        <input type="submit" value="Guardar" class="boton boton-2">

    </form>
</div>