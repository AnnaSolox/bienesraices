<?php

namespace App;

/**
 * Class Propiedad
 * 
 * @property int|null $id
 * @property string   $titulo
 * @property string   $precio
 * @property string   $imagen
 * @property string   $descripcion
 * @property int      $habitaciones
 * @property int      $wc
 * @property int      $estacionamiento
 * @property int|null $vendedor_id
 * @property string   $creado
 */
class Propiedad extends ActiveRecord
{
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedor_id'];

    protected static $errores = [
        'titulo' => '',
        'precio' => '',
        'descripcion' => '',
        'habitaciones' => '',
        'wc' => '',
        'estacionamiento' => '',
        'vendedor' => '',
        'imagen' => ''
    ];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $vendedor_id;
    public $creado;

    public function __construct(
        array $args = []
    ) {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? 0;
        $this->wc = $args['wc'] ?? 0;
        $this->estacionamiento = $args['estacionamiento'] ?? 0;
        $this->vendedor_id = $args['vendedor_id'] ?? null;
        $this->creado = $args['creado'] ?? date('Y-m-d');
    }

    public function validar()
    {
        if (!$this->titulo) {
            static::$errores['titulo'] = "Debes añadir un título";
        }

        if (!$this->precio) {
            static::$errores['precio'] = "El precio es obligatorio";
        }

        if (strlen($this->descripcion) < 50) {
            static::$errores['descripcion'] = "La descripción es obligatoria y debe tener más de 50 caracteres";
        }

        if (!$this->habitaciones) {
            static::$errores['habitaciones'] = "El número de habitaciones es obligatorio";
        }

        if (!$this->wc) {
            static::$errores['wc'] = "El número de baños es obligatorio";
        }

        if (!$this->estacionamiento) {
            static::$errores['estacionamiento'] = "El número de lugares de estacionamiento es obligatorio";
        }

        if (!$this->vendedor_id) {
            static::$errores['vendedor'] = "Elige un vendedor";
        }

        if (!$this->imagen) {
            static::$errores['imagen'] = "La imagen es obligatoria";
        } 

        return static::$errores;
    }
    
}
