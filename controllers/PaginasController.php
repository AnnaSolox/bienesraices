<?php

namespace Controllers;

use Exception;
use Model\Entrada;
use Model\Propiedad;
use Model\Usuario;
use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{

    public static function index(Router $router)
    {
        $propiedades = Propiedad::getLimited(3);
        $entradas = Entrada::getLimited(2);
        $usuarios = Usuario::getAll();

        $usuariosMap = [];
        foreach($usuarios as $usuario) {
            $usuariosMap[$usuario->id] = $usuario->nombre;
        }
        $inicio = true;

        $router->render('/paginas/index', [
            'propiedades' => $propiedades,
            'entradas' => $entradas,
            'usuarios' => $usuariosMap,
            'inicio' => $inicio
        ]);
    }

    public static function nosotros(Router $router)
    {
        $router->render('/paginas/nosotros', []);
    }

    public static function propiedades(Router $router)
    {
        $propiedades = Propiedad::getAll();
        $router->render('paginas/propiedades', [
            'propiedades' => $propiedades
        ]);
    }

    public static function propiedad(Router $router)
    {
        $propiedad = validarModeloORedireccionar(Propiedad::class, '/propiedades');

        $router->render('paginas/propiedad', [
            'propiedad' => $propiedad
        ]);
    }

    // TODO: hacer blog dinámico
    public static function blog(Router $router)
    {
        $entradas = Entrada::getAll();
        $usuarios = Usuario::getAll();

        $usuariosMap = [];
        foreach($usuarios as $usuario) {
            $usuariosMap[$usuario->id] = $usuario->nombre;
        }

        $router->render('paginas/blog', [
            'entradas' => $entradas,
            'usuarios' => $usuariosMap
        ]);
    }

    public static function entrada(Router $router)
    {
        $entrada = validarModeloORedireccionar(Entrada::class, '/blog');
        $usuario = Usuario::getById($entrada->usuario_id);

        $router->render('paginas/entrada', [
            'entrada' => $entrada,
            'usuario' => $usuario
        ]);
    }

    public static function contacto(Router $router)
    {
        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            // debuguear($respuestas);

            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            try {
                // Configurar SMTP
                $mail->isSMTP();
                $mail->Host = $_ENV['MAIL_HOST'];
                $mail->SMTPAuth = true;
                // $mail->SMTPDebug = 2;
                // $mail->Debugoutput = 'html';
                $mail->Username = $_ENV['MAIL_USER'];
                $mail->Password = $_ENV['MAIL_PASSWORD'];
                $mail->SMTPSecure = 'tls';
                $mail->Port = $_ENV['MAIL_PORT'];
                $mail->AuthType = 'LOGIN';

                // Configurar contenido del mail
                $mail->setFrom('test@example.com', 'Prueba');
                $mail->addAddress('destino@example.com', 'Destinatario');
                $mail->Subject = 'Tienes un nuevo mensaje';

                // Habilitar HTML
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';

                $contenido = '<html>';
                $contenido .= '<p>Tienes un nuevo mensaje</p></html>';
                $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';

                if ($respuestas['contacto'] === 'telefono') {
                    $contenido .= '<p>Eligió ser contactado por teléfono:</p>';
                    $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . ' </p>';
                    $contenido .= '<p>Fecha de contacto: ' . $respuestas['fecha'] . ' </p>';
                    $contenido .= '<p>Hora: ' . $respuestas['hora'] . ' h </p>';
                } else {
                    $contenido .= '<p>Eligió ser contactado por email:</p>';
                    $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
                }

                $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
                $contenido .= '<p>Vende o compra: ' . $respuestas['tipo'] . ' </p>';
                $contenido .= '<p>Precio o presupuesto: ' . $respuestas['presupuesto'] . '$ </p>';
                $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . ' </p>';
                $contenido .= '</html>';

                $mail->Body = $contenido;
                $mail->AltBody = 'Esto es texto alternativo sin HTML';

                
                //Enviar el email
                if ($mail->send()) {
                    $mensaje = "Mensaje enviado correctamente";
                } else {
                    echo "Error al enviar el mensaje: " . $mail->ErrorInfo;
                }
            } catch (Exception) {
                echo "Error al enviar el mensaje: " . $mail->ErrorInfo;
            }
        }

        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
}
