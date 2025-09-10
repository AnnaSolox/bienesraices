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
        $this->vendedor_id = $args['vendedor_id'] ?? 1;
        $this->creado = $args['creado'] ?? date('Y-m-d');
    }

    public function guardar() {
        if (!is_null($this->id)){
            $this->actualizar();
        } else {
            $this->crear();
        }
    }

    public function crear()
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
        
        if ($resultado) {
            header('Location: /admin?resultado=1'); 
        }
    }

    public function actualizar() {
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "$key = '$value'";
        }

        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            header('Location: /admin?resultado=2'); 
        }
    }

    public function eliminar(){
         $query = "DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
         $resultado = self::$db->query($query);
         if ($resultado) {
            $this->eliminarImagen();
            header('Location: /admin?resultado=3');
        }
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

    public function eliminarImagen(){
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
    }

    public function setImagen($imagen){
        if(!is_null($this->id)){
            $this->eliminarImagen();
        }
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    public static function getAll(){
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function getById($id){
        $query = "SELECT * FROM propiedades WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        //Consultar BBDD
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjeto($registro);
        }

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new self;

        foreach($registro as $key => $value){
            if( property_exists( $objeto, $key) ){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public function sincronizar($args = []){
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
