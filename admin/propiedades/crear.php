<?php

require '../../includes/config/database.php';
$db = conectarDB();

// Consultar para obtener los vendedores
$consulta_vendedores = "SELECT * FROM vendedores";
$resultado_vendedores = mysqli_query($db, $consulta_vendedores);

require '../../includes/funciones.php';
incluirTemplate('header');

// Array con mensajes de error
$errores = [
    'titulo' => '',
    'precio' => '',
    'descripcion' => '',
    'habitaciones' => '',
    'wc' => '',
    'estacionamiento' => '',
    'vendedor' => '',
    'imagen' => ''
];
    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedor_id = '';
    $imagen = '';

// Ejecutar el código después de enviar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* echo "<pre>";
    var_dump($_FILES);
    echo "</pre>";

    exit; */

    /* mysqli_real_escape_string se encarga de validar los datos introducidos por el usuario y evitar sentencias maliciosas */
    $titulo = mysqli_real_escape_string( $db, $_POST['titulo'] );
    $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
    $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion'] );
    $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones'] );
    $wc = mysqli_real_escape_string( $db, $_POST['wc'] );
    $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento'] );
    $vendedor_id = mysqli_real_escape_string( $db, $_POST['vendedor'] ?? '');

    // Asignar files hacia una variable
    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores['titulo'] = "Debes añadir un título";
    }

    if (!$precio) {
        $errores['precio'] = "El precio es obligatorio";
    }

    if (strlen($descripcion) < 50) {
        $errores['descripcion'] = "La descripción es obligatoria y debe tener más de 50 caracteres";
    }

    if (!$habitaciones) {
        $errores['habitaciones'] = "El número de habitaciones es obligatorio";
    }

    if (!$wc) {
        $errores['wc'] = "El número de baños es obligatorio";
    }

    if (!$estacionamiento) {
        $errores['estacionamiento'] = "El número de lugares de estacionamiento es obligatorio";
    }

    if (!$vendedor_id) {
        $errores['vendedor'] = "Elige un vendedor";
    }

    if (!$imagen['name']) {
        $errores['imagen'] = "La imagen es obligatoria";
    }

    // Validar por tamaño
    $medida = 1000 * 200;

    if ($imagen['size'] > $medida || $imagen['error']) {
        $errores['imagen'] = "La imagen debe tener un tamaño inferior a 200kb";
    }

    // Revisar que no haya errores
    if (!array_filter($errores)) {
        
        /* SUBIDA DE ARCHIVOS */

        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)){mkdir($carpetaImagenes);}

        // Generar nombre único
        $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

        // Subir la imagen
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

        // Insertar en la base de datos
        $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, vendedor_id) 
        VALUES ( '$titulo', '$precio', '$nombreImagen' , '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedor_id' )";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /admin'); //Redireccionar al panel admin
        }
    }
}
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton-verde">Volver</a>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Información general</legend>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título propiedad" value="<?php echo $titulo; ?>">
            <?php if($errores['titulo']): ?>
                <div class="alerta"><?php echo $errores['titulo']; ?></div>
            <?php endif; ?>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $precio; ?>">
            <?php if($errores['precio']): ?>
                <div class="alerta"><?php echo $errores['precio']; ?></div>
            <?php endif; ?>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <?php if($errores['precio']): ?>
                <div class="alerta"><?php echo $errores['imagen']; ?></div>
            <?php endif; ?>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php if($descripcion !== '') echo $descripcion; ?></textarea>
            <?php if($errores['descripcion']): ?>
                <div class="alerta"><?php echo $errores['descripcion']; ?></div>
            <?php endif; ?>
        </fieldset>

        <fieldset>
            <legend>Información propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">
            <?php if($errores['habitaciones']): ?>
                <div class="alerta"><?php echo $errores['habitaciones']; ?></div>
            <?php endif; ?>

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">
            <?php if($errores['wc']): ?>
                <div class="alerta"><?php echo $errores['wc']; ?></div>
            <?php endif; ?>

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            <?php if($errores['estacionamiento']): ?>
                <div class="alerta"><?php echo $errores['estacionamiento']; ?></div>
            <?php endif; ?>
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="" selected disabled>-- Seleccionar vendedor --</option>
                <?php while($row = mysqli_fetch_assoc($resultado_vendedores) ): ?>
                    <option <?php echo $vendedor_id === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre'] . ' ' . $row['apellido']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <?php if($errores['vendedor']): ?>
                <div class="alerta"><?php echo $errores['vendedor']; ?></div>
            <?php endif; ?>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton-verde">

    </form>
</main>

<?php incluirTemplate('footer'); ?>