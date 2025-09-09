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

$propiedad = new Propiedad();

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
        <?php incluirTemplate('formulario_propiedades', false, ['propiedad' => $propiedad, 'errores' => $errores, 'resultado_vendedores' => $resultado_vendedores]); ?>
       
        <input type="submit" value="Crear propiedad" class="boton-verde">

    </form>
</main>

<?php incluirTemplate('footer'); ?>