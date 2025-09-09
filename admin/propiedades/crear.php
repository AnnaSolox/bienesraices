<?php

require '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

estaAutenticado();

$db = conectarDB();

// Consultar para obtener los vendedores
$consulta_vendedores = "SELECT * FROM vendedores";
$resultado_vendedores = mysqli_query($db, $consulta_vendedores);

$errores = Propiedad::getErrores();


incluirTemplate('header');

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

    $propiedad = new Propiedad($_POST);

    // Generar nombre único
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    if($_FILES['imagen']['tmp_name']){
        $manager = new Image(Driver::class);
        $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    $errores = $propiedad->validar();

    // Revisar que no haya errores
    if (!array_filter($errores)) {
        /* SUBIDA DE ARCHIVOS */

        //Crear carpeta
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        //Guardar la imagen en el servidor
        $imagen->save(CARPETA_IMAGENES . $nombreImagen);

        $resultado = $propiedad->guardar();
        if ($resultado) {
            header('Location: /admin?resultado=1'); //Redireccionar al panel admin
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
            <?php if ($errores['imagen']): ?>
                <div class="alerta error"><?php echo $errores['imagen']; ?></div>
            <?php endif; ?>

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
                <div class="alerta error"><?php echo $errores['habitaciones']; ?></div>
            <?php endif; ?>

            <label for="wc">Baños:</label>
            <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">
            <?php if ($errores['wc']): ?>
                <div class="alerta error"><?php echo $errores['wc']; ?></div>
            <?php endif; ?>

            <label for="estacionamiento">Estacionamiento:</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            <?php if ($errores['estacionamiento']): ?>
                <div class="alerta error"><?php echo $errores['estacionamiento']; ?></div>
            <?php endif; ?>
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor_id">
                <option value="" selected disabled>-- Seleccionar vendedor --</option>
                <?php while ($row = mysqli_fetch_assoc($resultado_vendedores)): ?>
                    <option <?php echo $vendedor_id === $row['id'] ? 'selected' : ''; ?> value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre'] . ' ' . $row['apellido']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <?php if ($errores['vendedor']): ?>
                <div class="alerta error"><?php echo $errores['vendedor']; ?></div>
            <?php endif; ?>
        </fieldset>

        <input type="submit" value="Crear propiedad" class="boton-verde">

    </form>
</main>

<?php incluirTemplate('footer'); ?>