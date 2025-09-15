<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Entrada;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

class EntradaController
{
    public static function crear(Router $router)
    {
        $entrada = new Entrada;
        $errores = Entrada::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $entrada = new Entrada($_POST['entrada']);
            $entrada->usuario_id = $_SESSION['usuario_id'];

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
            if ($_FILES['entrada']['tmp_name']['imagen']) {
                $manager = new Image(Driver::class);
                $imagen = $manager->read($_FILES['entrada']['tmp_name']['imagen'])->cover(800, 600);
                $entrada->setImagen($nombreImagen);
            }

            $errores = $entrada->validar();

            // Revisar que no haya errores
            if (!array_filter($errores)) {
                /* SUBIDA DE ARCHIVOS */

                //Crear carpeta
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                //Guardar la imagen en el servidor
                $imagen->save(CARPETA_IMAGENES . $nombreImagen);

                // debuguear($entrada);

                $entrada->guardar();
            }
        }

        $router->render('entradas/crear', [
            'entrada' => $entrada,
            'errores' => $errores
        ]);
    }

    public static function actualizar() {}
    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $propiedad = Entrada::getById($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
