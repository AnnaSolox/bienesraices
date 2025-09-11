<?php

namespace Model;

/**
 * Clase base ActiveRecord
 *
 * @property int|null $id
 * @property string   $imagen
 */
class ActiveRecord
{
    //BBDD
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Errores
    protected static $errores = [];


    /**
     * @return static[]
     */
    // Definir la conexión a la BBDD
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function guardar()
    {
        if (!is_null($this->id)) {
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
        $query = " INSERT INTO " . static::$tabla . " (";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "') ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar()
    {
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "$key = '$value'";
        }

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            header('Location: /admin?resultado=2');
        }
    }

    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
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
        foreach (static::$columnasDB as $columna) {
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

    /**
     * @return static[]
     */
    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::getErrores();
    }

    public function eliminarImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    public function setImagen($imagen)
    {
        if (!is_null($this->id)) {
            $this->eliminarImagen();
        }
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    /**
     * @return static[]
     */
    public static function getAll()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /**
     * @return static[]
     */
    public static function getLimited($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    /**
     * @return static
     */
    public static function getById($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    /**
     * @return static[]
     */
    public static function consultarSQL($query)
    {
        //Consultar BBDD
        $resultado = self::$db->query($query);

        //Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    /**
     * @return static[]
     */
    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
