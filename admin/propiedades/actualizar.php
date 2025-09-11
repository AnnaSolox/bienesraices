<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

require '../../includes/app.php';
estaAutenticado();

// Validar la URL por ID válido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

// Consulta para obtener los datos de la propiedad
$propiedad = Propiedad::getById($id);

// Consultar para obtener los vendedores
$vendedores = Vendedor::getAll();

incluirTemplate('header');

// Array con mensajes de error
$errores = Propiedad::getErrores();


// Ejecutar el código después de enviar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);
    // debuguear($propiedad);

    $errores = $propiedad->validar();

    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $manager = new Image(Driver::class);
        $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    // Revisar que no haya errores
    if (!array_filter($errores)) {
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            //Almacenar la imagen
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);

            $propiedad->guardar();
        }
    }
}
?>

<main class="contenedor seccion">
    <h1>Actualizar</h1>

    <a href="/admin" class="boton-verde">Volver</a>

    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php incluirTemplate('formulario_propiedades', false, ['propiedad' => $propiedad, 'errores' => $errores, 'vendedores' => $vendedores]); ?>

        <input type="submit" value="Actualizar propiedad" class="boton-verde">

    </form>
</main>

<?php incluirTemplate('footer'); ?>