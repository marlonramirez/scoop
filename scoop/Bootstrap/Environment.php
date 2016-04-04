<?php
namespace Scoop\Bootstrap;

abstract class Environment
{
    private $router;
    private $config;
    private static $sessionInit = false;

    public function __construct($fileConfig)
    {
        if (!self::$sessionInit) {
            self::$sessionInit = session_start();
        }
        $this->config = require $fileConfig.'.php';
        $this->router = new \Scoop\IoC\Router($this->config['routes']);
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function get($name)
    {
        $name = explode('.', $name);
        $res = $this->config;
        foreach ($name as $key) {
            if (!isset($res[$key])) {
                return false;
            }
            $res = $res[$key];
        }
        return $res;
    }

    protected function bind($interface, $class)
    {
        \Scoop\IoC\Injector::bind($interface, $class);
        return $this;
    }

    protected function registerService($name, $class)
    {
        \Scoop\IoC\Service::register($name, $class);
        return $this;
    }
}
