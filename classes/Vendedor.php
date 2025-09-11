<?php

namespace App;

/**
 * @property int|null $id
 * @property string   $nombre
 * @property string   $apellido
 * @property string   $telefono
 */
class Vendedor extends ActiveRecord 
{
    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    protected static $errores = [
        'nombre' => '',
        'apellido' => '',
        'telefono' => ''
    ];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct(
        array $args = []
    ) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) {
            static::$errores['nombre'] = "El nombre es obligatorio";
        }

        if (!$this->apellido) {
            static::$errores['apellido'] = "El apellido es obligatorio";
        }

        if (!$this->telefono) {
            static::$errores['telefono'] = "El telefono es obligatorio";
        } else if(!preg_match('/[0-9]{9}/', $this->telefono)){
            static::$errores['telefono'] = "Formato no válido";
        }

        return static::$errores;
    }
}