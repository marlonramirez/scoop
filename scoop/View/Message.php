<?php
namespace Scoop\View;

/**
 * Contenedor de los mensajes usados por el Bootstrap.
 */
final class Message
{
    /**
     * Tipo de salida estandar de los mensajes.
     */
    const OUT = 'out';
    /**
     * Tipo de salida como error.
     */
    const ERROR = 'error';
    /**
     * Tipo de salida como advertencia.
     */
    const WARNING = 'warning';
    /**
     * @var string Contenido del mensaje.
     */
    private $msg;

    /**
     * Establece la plantilla del mensaje como msg-not
     */
    public function __construct()
    {
        $this->msg = '<div id="msg-not"><i class="fa fa-times"></i><span></span></div>';
    }

    /**
     * Valida y muestra el mensaje suministrado por el usuario.
     * @param string $msg  Mensaje a ser mostrado por la aplicación.
     * @param string $type Tipo de mensaje a mostrar.
     */
    public function push($msg, $type)
    {
        self::validate($type);
        $_SESSION['msg-scoop'] = array('type'=>$type, 'msg'=>$msg);
    }

    /**
     * Muestra y elimina el mensaje suministrado por el usuario.
     */
    public function pull()
    {
        if (isset($_SESSION['msg-scoop'])) {
            $this->setMsg($_SESSION['msg-scoop']['type'], $_SESSION['msg-scoop']['msg']);
            unset($_SESSION['msg-scoop']);
        }
    }

    /**
     * Valida y muestra el mensaje suministrado por el usuario.
     * @param string $msg  Mensaje a ser mostrado por la aplicación.
     * @param string $type Tipo de mensaje a mostrar.
     */
    public function set($msg, $type)
    {
        self::validate($type);
        $this->setMsg($type, $msg);
    }

    /**
     * Muestra la propiedad $msg cuando se intenta tratar a la clase como us string.
     * @return string Propiedad $msg.
     */
    public function __toString()
    {
        return $this->msg;
    }

    /**
     * Establece la plantilla para el tipo enviado.
     * @param string $type Tipo de mensaje: out, warning, error.
     * @param string $msg Descripción del mensaje enviado por el usuario.
     */
    private function setMsg($type, $msg)
    {
        $this->msg = '<div id="msg-'.$type.'"><i class="fa fa-times"></i><span>'.$msg.'</span></div>';
    }

    /**
     * Verifica que el tipo de mensaje enviado sea valido.
     * @param string $type Tipo de mensaje.
     * @throws \Exception Si no es un tipo de mensaje valido.
     */
    private static function validate($type)
    {
        if ($type !== self::OUT && $type !== self::ERROR && $type !== self::WARNING) {
            throw new \UnexpectedValueException('Error building only accepted message types: out, warning and error.');
        }
    }
}
