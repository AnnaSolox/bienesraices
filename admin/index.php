<?php 

    $resultado = $_GET['resultado'] ?? null;

    require '../includes/funciones.php';
    incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes raíces</h1>
    <?php if(intval($resultado) === 1) : ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>

            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <td>1</td>
            <td>Casa en la playa</td>
            <td><img src="/imagenes/1a5f0a8e809b3e36fc0d4e8d1d132649.jpg" alt="imagen propiedad" class="imagen-tabla"></td>
            <td>$120000</td>
            <td>
                <a class="boton-rojo-block" href="#">Eliminar</a>
                <a class="boton-amarillo-block" href="#">Actualizar</a>
            </td>
        </tbody>

    </table>
</main>

<?php incluirTemplate('footer'); ?>