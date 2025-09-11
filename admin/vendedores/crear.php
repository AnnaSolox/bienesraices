<?php

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor;
$errores = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendedor = new Vendedor($_POST['vendedor']);

    $errores = $vendedor->validar();

    if(!array_filter($errores)){
        $vendedor->guardar();
    }
}

incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>

    <a href="/admin" class="boton-verde">Volver</a>

    <form class="formulario" method="POST" action="/admin/vendedores/crear.php">
        <?php incluirTemplate('formulario_vendedores', false, ['vendedor' => $vendedor, 'errores' => $errores]); ?>
       
        <input type="submit" value="Crear vendedor(a)" class="boton-verde">

    </form>
</main>

<?php
    incluirTemplate('footer');
?>
