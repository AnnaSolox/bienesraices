<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar sesión</h1>

    <form method="POST" class="formulario" action="/login">
         <fieldset>
            <legend>Email y password</legend>

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Tu email" id="email">
            <?php if($errores['email']) : ?>
                <div class="alerta error"><?php echo $errores['email']; ?></div>
            <?php endif; ?>

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu password" id="telefono">
            <?php if($errores['password']) : ?>
                <div class="alerta error"><?php echo $errores['password']; ?></div>
            <?php endif; ?>

            <?php if($errores['comprobacion_usuario']) : ?>
                <div class="alerta error"><?php echo $errores['comprobacion_usuario']; ?></div>
            <?php endif; ?>
            <?php if($errores['comprobacion_password']) : ?>
                <div class="alerta error"><?php echo $errores['comprobacion_password']; ?></div>
            <?php endif; ?>

            <input type="submit" value="Iniciar sesión" class="boton-verde">

        </fieldset>
    </form>
</main>