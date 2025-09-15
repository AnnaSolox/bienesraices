<?php

namespace Controllers;

use Exception;
use Model\Entrada;
use Model\Propiedad;
use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{

    public static function index(Router $router)
    {
        $propiedades = Propiedad::getLimited(3);
        $inicio = true;

        $router->render('/paginas/index', [
            'propiedades' => $propiedades,
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
        $router->render('paginas/blog', [
            'entradas' => $entradas
        ]);
    }

    public static function entrada(Router $router)
    {
        $entrada = validarModeloORedireccionar(Entrada::class, '/blog');

        $router->render('paginas/entrada', [
            'entrada' => $entrada
        ]);
    }

    public static function contacto(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            // debuguear($respuestas);
            
            // Crear una instancia de PHPMailer
            $mail = new PHPMailer();

            try {
                // Configurar SMTP
                $mail->isSMTP();
                $mail->Host = getenv('MAIL_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = getenv('MAIL_USER');
                $mail->Password = getenv('MAIL_PASSWORD');
                $mail->SMTPSecure = 'tls';
                $mail->Port = getenv('MAIL_PORT');
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
                $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
                $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . ' </p>';
                $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
                $contenido .= '<p>Vende o compra: ' . $respuestas['tipo'] . ' </p>';
                $contenido .= '<p>Precio o presupuesto: ' . $respuestas['presupuesto'] . '$ </p>';
                $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto'] . ' </p>';
                $contenido .= '<p>Fecha de contacto: ' . $respuestas['fecha'] . ' </p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . ' h </p>';
                $contenido .= '</html>';

                $mail->Body = $contenido;
                $mail->AltBody = 'Esto es texto alternativo sin HTML';

                //Enviar el email
                if ($mail->send()) {
                    echo "Mensaje enviado correctamente";
                } else {
                    echo "Error al enviar el mensaje: " . $mail->ErrorInfo;
                }
            } catch (Exception) {
                echo "Error al enviar el mensaje: " . $mail->ErrorInfo;
            }
        }

        $router->render('paginas/contacto');
    }
}
