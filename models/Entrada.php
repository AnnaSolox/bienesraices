<?php

namespace Model;

/**
 * Class Entrada
 * 
 * @property int|null $id
 * @property string   $imagen
 * @property string   $titulo
 * @property string   $fecha
 * @property int|null $usuario
 * @property string   $resumen
 * @property string   $contenido
 */
class Entrada extends ActiveRecord {
    protected static $tabla = 'entradas';
    protected static $columnasDB = ['id', 'titulo', 'fecha', 'usuario_id', 'resumen'. 'contenido'];

    public $id;
    public $imagen;
    public $titulo;
    public $fecha;
    public $usuario_id;
    public $resumen;
    public $contenido;

    public function __construct(
        array $args = []
    )
    {
        $this->id = $args['id'] ?? null;
        $this->imagen = $args['imagen'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->fecha = $args['fecha'] ?? date('Y-m-d');
        $this->usuario_id = $args['usuario_id'] ?? null;
        $this->resumen = $args['resumen'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
    }

}