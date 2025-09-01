<?php

require '../../includes/config/database.php';
$db = conectarDB();

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
];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedor_id = '';

// Ejecutar el código después de enviar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamiento = $_POST['estacionamiento'];
    $vendedor_id = $_POST['vendedor'] ?? '';

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

    // Revisar que no haya errores
    if (empty($errores)) {
        // Insertar en la base de datos
        $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedor_id) 
        VALUES ( '$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedor_id' )";

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            echo "Insertado correctamente";
        }
    }
}
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/admin" class="boton-verde">Volver</a>

    <form class="formulario" method="POST" action="/admin/propiedades/crear.php">
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
            <input type="file" id="imagen" accept="imagen/jpeg, image/png">

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
                <option value="" disabled selected>-- Seleccionar vendedor --</option>
                <option value="1">Anna</option>
                <option value="2">Erika</option>
            </select>
            <?php if($errores['vendedor']): ?>
                <div class="alerta"><?php echo $errores['vendedor']; ?></div>
            <?php endif; ?>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton-verde">

    </form>
</main>

<?php incluirTemplate('footer'); ?>