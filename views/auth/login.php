<div class="contenedor login">
    <div class="titulo">
        <h1 class="becabud">Beca<span>Bud</span></h1>
    </div>


    <form action="/" class="formulario" method="POST">
        <?php include_once __DIR__ . "/../templates/alertas.php"; ?>
            <div class="campo">
                <label for="email">Nombre de Usuario</label>
                <input type="text" id="email" name="email" placeholder="Usuario">
            </div>
            <div class="campo">
                <label for="contraseña">Contraseña</label>
                <input type="password" id="contraseña" name="contraseña" placeholder="Contraseña">
            </div>

            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
</div>

