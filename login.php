<?php

    require 'includes/config/database.php';
    $db = conectarDB();

    // Autenticar el usuario
    $errores = [
        'email' => '',
        'password' => '',
        'comprobacion_usuario' => '',
        'comprobacion_password' => ''
    ];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!$email){
            $errores['email'] = 'El email es obligatorio o no es válido';
        }

        if(!$password){
            $errores['password'] = 'El password es obligatorio';
        }

        if(!array_filter($errores)){
            $query = "SELECT * FROM usuarios WHERE email = '$email'";
            $resultado = mysqli_query($db, $query);
            
            if($resultado -> num_rows){
                // Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                $auth = password_verify($password, $usuario['password']);

                if($auth){
                    // El usuario está autenticado
                    session_start();

                    // llenar el array de la sesión
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header('Location: /admin');

                } else {
                    $errores['comprobacion_password'] = 'El password es incorrecto';
                }

            } else {
                $errores['comprobacion_usuario'] = 'El usuario no existe';
            }
        }

    }

    // Incluye el header
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar sesión</h1>

    <form method="POST" class="formulario">
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

<?php 
    incluirTemplate('footer');
?>