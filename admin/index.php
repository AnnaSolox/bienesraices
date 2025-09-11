<?php

require '../includes/app.php';
estaAutenticado();

use App\Propiedad;
use App\Vendedor;

//Implementar método para obtener todas las propiedades
$propiedades = Propiedad::getAll();
$vendedores = Vendedor::getAll();

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        $tipo = $_POST['tipo'];
        if (validarTipoContenido($tipo)) {
            if ($tipo === 'propiedad') {
                $propiedad = Propiedad::getById($id);
                $propiedad->eliminar();
            } else if ($tipo === 'vendedor') {
                $vendedor = Vendedor::getById($id);
                $vendedor->eliminar();
            }
        }
    }
}

// Incluye un template
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes raíces</h1>
    <?php if (intval($resultado) === 1) : ?>
        <p class="alerta exito">Creado correctamente</p>
    <?php elseif (intval($resultado) === 2) : ?>
        <p class="alerta exito">Actualizado correctamente</p>
    <?php elseif (intval($resultado) === 3) : ?>
        <p class="alerta exito">Eliminado correctamente</p>
    <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton-amarillo">Nuevo(a) vendedor</a>

    <h2>Propiedades</h2>

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
        <tbody><!-- Mostrar los resultados -->
            <?php foreach ($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="imagen propiedad" class="imagen-tabla"></td>
                    <td>$<?php echo $propiedad->precio; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input class="boton-rojo-block" type="submit" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>

            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody><!-- Mostrar los resultados -->
            <?php foreach ($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input class="boton-rojo-block" type="submit" value="Eliminar">
                        </form>
                        <a class="boton-amarillo-block" href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</main>

<?php
// Cerrar la conexión
mysqli_close($db);

incluirTemplate('footer');
?>