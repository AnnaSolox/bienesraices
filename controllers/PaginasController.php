<?php

namespace Controllers;

use Model\Entrada;
use Model\Propiedad;
use MVC\Router;

class PaginasController
{

    public static function index(Router $router)
    {
        $propiedades = Propiedad::getLimited(3);
        $inicio = true;

        $router->render('/paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('/paginas/nosotros', []);
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::getAll();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router)
    {
        $propiedad = validarModeloORedireccionar(Propiedad::class, '/propiedades');

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    // TODO: hacer blog dinámico
    public static function blog(Router $router)
    {
        $entradas = Entrada::getAll();
        $router->render('paginas/blog', [
            'entradas' => $entradas
        ]);
    }

    public static function entrada(Router $router)
    {
        $entrada = validarModeloORedireccionar(Entrada::class, '/blog');

        $router->render('paginas/entrada', [
            'entrada' => $entrada
        ]);
    }

    public static function contacto()
    {
        echo "Desde contacto";
    }
}
