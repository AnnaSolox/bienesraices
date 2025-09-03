<?php

// Validar la URL por ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

require '../../includes/config/database.php';
$db = conectarDB();

// Consulta para obtener los datos de la propiedad
$consulta_propiedad = "SELECT * FROM propiedades WHERE id = $id";
$resultado_propiedad = mysqli_query($db, $consulta_propiedad);
$propiedad = mysqli_fetch_assoc($resultado_propiedad);

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
$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedor_id = $propiedad['vendedor_id'];
$imagen_propiedad = $propiedad['imagen'];

var_dump($imagen_propiedad);

// Ejecutar el código después de enviar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* mysqli_real_escape_string se encarga de validar los datos introducidos por el usuario y evitar sentencias maliciosas */
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedor_id = mysqli_real_escape_string($db, $_POST['vendedor'] ?? '');

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

    // Validar por tamaño
    $medida = 1024 * 200;

    if (!$imagen) {
        if ($imagen['error'] !== 0) {
            $errores['imagen'] = "Hubo un error al subir la imagen";
        } else if ($imagen['size'] > $medida) {
            $errores['imagen'] = "La imagen debe tener un tamaño inferior a 200kb";
        }
    }

    echo "<pre>";
    var_dump($errores);
    echo "</pre>";

    // Revisar que no haya errores
    if (!array_filter($errores)) {

        /* SUBIDA DE ARCHIVOS */

        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = $imagen_propiedad;


        if ($imagen['name']) {
            // Eliminar la imagen previa
            unlink($carpetaImagenes . $imagen_propiedad);

            // Generar nombre único
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        }

        // Insertar en la base de datos
        $query = " UPDATE propiedades SET titulo = '$titulo', precio = $precio, descripcion = '$descripcion', imagen = '$nombreImagen', habitaciones = $habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedor_id = $vendedor_id WHERE id = $id ";

        $resultado = mysqli_query($db, $query);


        if ($resultado) {
            header('Location: /admin?resultado=2'); //Redireccionar al panel admin
        }
    }
}
?>

<main class="contenedor seccion">
    <h1>Actualizar</h1>

    <a href="/admin" class="boton-verde">Volver</a>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Información general</legend>

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Título propiedad" value="<?php echo $titulo; ?>">
            <?php if ($errores['titulo']): ?>
                <div class="alerta error"><?php echo $errores['titulo']; ?></div>
            <?php endif; ?>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $precio; ?>">
            <?php if ($errores['precio']): ?>
                <div class="alerta error"><?php echo $errores['precio']; ?></div>
            <?php endif; ?>

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">
            <?php if ($errores['precio']): ?>
                <div class="alerta error"><?php echo $errores['imagen']; ?></div>
            <?php endif; ?>
            <img src="/imagenes/<?php echo $imagen_propiedad ?>" alt="Imagen propiedad" class="imagen-small">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion"><?php if ($descripcion !== '') echo $descripcion; ?></textarea>
            <?php if ($errores['descripcion']): ?>
                <div class="alerta error"><?php echo $errores['descripcion']; ?></div>
            <?php endif; ?>
        </fieldset>

        <fieldset>
            <legend>Información propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">
            <?php if ($errores['habitaciones']): ?>
                <div class="alerta"><?php echo $errores['habitaciones']; ?></div>
            <?php endif; ?>

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">
            <?php if ($errores['wc']): ?>
                <div class="alerta"><?php echo $errores['wc']; ?></div>
            <?php endif; ?>

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            <?php if ($errores['estacionamiento']): ?>
                <div class="alerta"><?php echo $errores['estacionamiento']; ?></div>
            <?php endif; ?>
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="" selected disabled>-- Seleccionar vendedor --</option>
                <?php while ($row = mysqli_fetch_assoc($resultado_vendedores)): ?>
                    <option <?php echo $vendedor_id === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre'] . ' ' . $row['apellido']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <?php if ($errores['vendedor']): ?>
                <div class="alerta"><?php echo $errores['vendedor']; ?></div>
            <?php endif; ?>
        </fieldset>

        <input type="submit" value="Actualizar propiedad" class="boton-verde">

    </form>
</main>

<?php incluirTemplate('footer'); ?>