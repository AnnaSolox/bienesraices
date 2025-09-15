<?php

namespace Model;

/**
 * Class Usuario
 * 
 * @property int|null $id
 * @property string   $correo
 * @property string   $password
 * @property string   $nombre
 */
class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password', 'nombre'];

    protected static $errores = [
        'email' => '',
        'password' => '',
        'comprobacion_usuario' => '',
        'comprobacion_password' => ''
    ];

    public $id;
    public $email;
    public $password;
    public $nombre;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
    }

    public function validar()
    {
        if(!$this->email){
            self::$errores['email'] = 'El email es obligatorio o no es válido';
        }

        if(!$this->password){
            self::$errores['password'] = 'El password es obligatorio';
        }

        return self::$errores;
    }

    public function existeUsuario(){
        $query = "SELECT * FROM " .  self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        // debuguear($resultado);

        if(!$resultado->num_rows){
            self::$errores['comprobacion_usuario'] = 'El usuario no existe';
            return;
        }

        return $resultado;
    }

    public function comprobarPassword($resultado){
        $usuario = $resultado->fetch_object();
        
        $autenticado = password_verify($this->password, $usuario->password);
        if(!$autenticado){
            self::$errores['comprobacion_password'] = 'El password es incorrecto';
        } else {
            $this->setId($usuario->id);
        }

        return $autenticado;
    }

    public function autenticar(){
        session_start();
        
        $_SESSION['usuario'] = $this->email;
        $_SESSION['usuario_id'] = $this->id;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }

    protected function setId($id){
        $this->id = $id;
    }
}