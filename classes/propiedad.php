<?php

namespace App;

class Propiedad
{

    //BBDD
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedor_id'];

    //Errores
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

    // Definir la conexión a la BBDD
    public static function setDB($database)
    {
        self::$db = $database;
    }

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

    public function guardar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en BBDD
        $query = " INSERT INTO propiedades (";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "') ";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Identificar y unir los atributos de la BBDD.
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            if ($value === null) {
                $sanitizado[$key] = '';
            } else {
                $sanitizado[$key] = self::$db->escape_string($value);
            }
        }

        return $sanitizado;
    }

    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores['titulo'] = "Debes añadir un título";
        }

        if (!$this->precio) {
            self::$errores['precio'] = "El precio es obligatorio";
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores['descripcion'] = "La descripción es obligatoria y debe tener más de 50 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores['habitaciones'] = "El número de habitaciones es obligatorio";
        }

        if (!$this->wc) {
            self::$errores['wc'] = "El número de baños es obligatorio";
        }

        if (!$this->estacionamiento) {
            self::$errores['estacionamiento'] = "El número de lugares de estacionamiento es obligatorio";
        }

        if (!$this->vendedor_id) {
            self::$errores['vendedor'] = "Elige un vendedor";
        }

        if (!$this->imagen) {
            self::$errores['imagen'] = "La imagen es obligatoria";
        } 

        return self::$errores;
    }

    public function setImagen($imagen){
        if($imagen){
            $this->imagen = $imagen;
        }
    }
}
