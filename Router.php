<?php

namespace MVC;

class Router {

    public $rutasGet = [];
    public $rutasPost = [];

    public function get($url, $fn){
        $this->rutasGet[$url] = $fn;
    }

    public function comporbarRutas(){
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
        
        if($metodo === 'GET'){
            $fn = $this->rutasGet[$urlActual] ?? null;
        }

        if($fn) {
            call_user_func($fn, $this);
        } else {
            echo "Página no encontrada";
        }
    }

    public function render($view){

        ob_start();

        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";
    }
}

?>