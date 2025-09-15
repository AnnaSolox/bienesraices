<?php 

namespace Controllers;
use MVC\Router;
use Model\Usuario;

class LoginController {
    public static function login(Router $router){
        $errores = Usuario::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST); 
            $errores = $usuario->validar();

            if(!array_filter($errores)){
                $resultado = $usuario->existeUsuario();

                if(!$resultado){
                    $errores = Usuario::getErrores();
                } else {
                    $autenticado = $usuario->comprobarPassword($resultado);

                    if($autenticado){
                        $usuario->autenticar();

                    } else {
                        $errores = Usuario::getErrores();
                    }
                }
            }
        }

        $router->render('auth/login', ['errores' => $errores]);    
    }
    public static function logout(){
        session_start();

        $_SESSION = [];
        header('Location: /');
    }

}