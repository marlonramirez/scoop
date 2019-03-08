<?php
namespace Scoop;

/**
 * Clase que implementa los métodos y atributos necesarios para poder manejar de
 * manera más sencilla los controladores de la aplicación.
 */
abstract class Controller
{
    /**
     * Lista de posibles redirecciones del controlador.
     * @var array
     */
    private static $redirects = array(
        300 => 'HTTP/1.1 300 Multiple Choices',
        301 => 'HTTP/1.1 301 Moved Permanently',
        302 => 'HTTP/1.1 302 Found',
        303 => 'HTTP/1.1 303 See Other',
        304 => 'HTTP/1.1 304 Not Modified',
        305 => 'HTTP/1.1 305 Use Proxy',
        306 => 'HTTP/1.1 306 Not Used',
        307 => 'HTTP/1.1 307 Temporary Redirect',
        308 => 'HTTP/1.1 308 Permanent Redirect'
    );

    /**
     * Realiza la redirección a la página pasada como parámetro.
     * @param string $url Dirección a la que se redirecciona la página.
     * @param integer $status Codigo de la redirección que se va a realizar.
     */
    public static function redirect($url, $status = 302)
    {
        header(self::$redirects[$status], true, $status);
        if (is_array($url)) {
            $router = \Scoop\Context::getService('config')->router;
            $url = $router->getURL(array_shift($url), $url);
        }
        header('Location:'.$url);
        exit;
    }

    /**
     * Emite una excepción 404 desde el controlador.
     * @param string $msg Mensaje enviado a la excepción.
     * @throws Http\NotFoundException La excepción not found.
     */
    protected function notFound($msg = null)
    {
        throw new \Scoop\Http\NotFoundException($msg);
    }

    /**
     * Emite una excepción 403 desde el controlador.
     * @param string $msg Mensaje enviado a la excepción.
     * @throws Http\accessDeniedException La excepción access denied.
     */
    protected function accessDenied($msg = null)
    {
        throw new \Scoop\Http\AccessDeniedException($msg);
    }

    /**
     * Emite una excepción 400 desde el controlador.
     * @param string $msg Mensaje en formato json enviado a la excepción.
     * @throws Http\BadRequestException La excepción bad request.
    */
    protected function fail($errors, $jsonResponse = false)
    {
        if ($jsonResponse) {
            $jsonResponse = json_encode($errors);
            throw new \Scoop\Http\BadRequestException($jsonResponse? $jsonResponse: $errors);
        }
        $_SESSION['errors-scoop'] = $errors;
        self::redirect($_SERVER['HTTP_REFERER'], 307);
    }

    /**
     * Obtiene el servicio especificado por el usuario.
     * @param string $serviceName Nombre del servicio a obtener.
     * @return object Servicio a obtener.
     */
    protected function inject($serviceName)
    {
        return \Scoop\Context::getService($serviceName);
    }

    public function __get($name)
    {
        if ($name === 'request') {
            return \Scoop\Context::getRequest();
        }
    }
}
