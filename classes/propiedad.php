<?php

namespace App;

class Propiedad
{

    //BBDD
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedor_id'];

    public ?int $id;
    public string $titulo;
    public string $precio;
    public string $imagen;
    public string $descripcion;
    public int $habitaciones;
    public int $wc;
    public int $estacionamiento;
    public ?int $vendedor_id;
    public string $creado;

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
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
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
        $query .=" ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "') ";

        $resultado = self::$db->query($query);
        debuguear($resultado);
    }

    // Identificar y unir los atributos de la BBDD.
    public function atributos(){
        $atributos = [];
        foreach (self::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }
}
