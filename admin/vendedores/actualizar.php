<?php

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) {
    header('Location: /admin');
}

$vendedor = Vendedor::getById($id);
$errores = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $args = $_POST['vendedor'];
    $vendedor->sincronizar($args);

    $errores = $vendedor->validar();

    if(!array_filter($errores)){
        $vendedor->guardar();
    }
}

incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>

    <a href="/admin" class="boton-verde">Volver</a>

    <form class="formulario" method="POST">
        <?php incluirTemplate('formulario_vendedores', false, ['vendedor' => $vendedor, 'errores' => $errores]); ?>
       
        <input type="submit" value="Actualizar vendedor(a)" class="boton-verde">

    </form>
</main>

<?php
    incluirTemplate('footer');
?>
