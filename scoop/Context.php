<?php
namespace Scoop;

class Context
{
    private static $connections = array();
    private static $loader;
    private static $service;
    private static $injector;
    private static $environment;
    private static $dispatcher;

    /**
     * Ejecuta la carga automatica de clases mediante Composer o con una clase propia.
     * @return vendor|\Scoop\Bootstrap\Loader El cargador usado para ejecutar la carga.
     */
    public static function load(string $configPath)
    {
        if (isset(self::$loader)) {
            throw new \Exception('Context loaded');
        }
        if (is_readable('vendor/autoload.php')) {
            self::$loader = require 'vendor/autoload.php';
        } else {
            require 'scoop/Bootstrap/Loader.php';
            self::$loader = new \Loader();
            $conf = json_decode(file_get_contents('composer.json'), true);
            $psr4 = $conf['autoload']['psr-4'];
            foreach ($psr4 as $key => $value) {
                self::$loader->setPsr4($key, $value);
            }
            self::$loader->register(true);
        }
        self::$environment = new \Scoop\Bootstrap\Environment($configPath);
        self::configureInjector();
        self::configureDispatcher();
    }

    /**
     * Conecta a una base de datos
     * @param string|array<mixed> $bundle El nombre del configuration bundle (EJ: default)
     *  o un array con los datos de configuración necesaria para la creación (database, user).
     * @return \Scoop\Storage\DBC La conexión establecida con el servidor.
     */
    public static function connect($bundle = null)
    {
        $config = self::getDBConfig($bundle);
        $config = self::normalizeDBConfig($config);
        $key = implode('', $config);
        if (!isset(self::$connections[$key])) {
            self::$connections[$key] = new Storage\DBC(
                $config['database'],
                $config['user'],
                $config['password'],
                $config['host'],
                $config['driver']
            );
        }
        return self::$connections[$key];
    }

    public static function getLoader()
    {
        return self::$loader;
    }

    public static function getEnvironment()
    {
        return self::$environment;
    }

    /**
     * Obtiene la instancia del injector según las capacidades del servidor.
     * @return \Scoop\Container\Injector El injector apropiado para el servidor.
     * @deprecated
     */
    public static function getInjector()
    {
        return self::$injector;
    }

    public static function inject(string $id)
    {
        return self::$injector->get($id);
    }

    public static function dispatchEvent(\Scoop\Event $event)
    {
        return self::$dispatcher->dispatch($event);
    }

    /**
     * Obtiene un servicio configurado previamente
     * @deprecated
     * @param string $service Nombre del servicio a buscar.
     * @return object Servicio hallado.
     * @throws \UnderflowException Si no se ha registrado ningún servicio arroja la excepción.
     */
    public static function getService($service)
    {
        if (!self::$service) {
            throw new \UnderflowException('No service '.$service.' registered');
        }
        return self::$service->get($service);
    }

    /**
     * Registra un servicio en el service manager.
     * @deprecated
     * @param string $key Nombre del servicio
     * @param string|object $callback Nombre de la clase del servicio
     *  o el objeto mismo que representa el servicio.
     * @param array<mixed> $params Parametros enviados al servicio.
     */
    public static function registerService($key, $callback, $params = array())
    {
        if (!self::$service) {
            self::$service = new \Scoop\Container\Service();
        }
        self::$service->register($key, $callback, $params);
    }

    /**
     * Obtiene la configuración de la base de datos establecida en /app/config::db
     * Tambien puede mezclar los datos del array con los de la configuración por defecto.
     * @param string|array<array<string>> $bundle El nombre del configuration bundle (EJ: default)
     *  o un array con los datos de configuración necesaria para la creación (database, user).
     * @return array<array<string>> Array de configuración.
     */
    private static function getDBConfig($bundle)
    {
        if (is_string($bundle)) return self::$environment->getConfig('db'.$bundle);
        $config = self::$environment->getConfig('db.default');
        if (is_array($bundle)) {
            $config += $bundle;
        }
        return $config;
    }

    /**
     * Agrega los datos por defecto para ejecutar la configuración.
     * @param array<array<string>> $config Array de configuración.
     * @return array<array<string>> Configuración normalizada.
     */
    private static function normalizeDBConfig($config)
    {
        $requireds = array('database', 'user');
        foreach ($requireds as $required) {
            if (!isset($config[$required])) {
                throw new \OutOfBoundsException('Property '.$required.
                ' not found in database configuration');
            }
        }
        return array_merge(array(
            'password' => '',
            'host' => '127.0.0.1',
            'driver' => 'pgsql'
        ), $config);
    }

    private static function configureInjector()
    {
        $injector = self::$environment->getConfig('injector', '\Scoop\Container\BasicInjector');
        $baseInjector = '\Scoop\Container\Injector';
        self::$injector = new $injector(self::$environment);
        if (!(self::$injector instanceof $baseInjector)) {
            throw new \UnexpectedValueException($injector.' not implement '.$baseInjector);
        }
    }

    private static function configureDispatcher()
    {
        $listeners = (Array) self::$environment->getConfig('events');
        $eventBus = new \Scoop\Event\Bus($listeners);
        self::$dispatcher = new \Scoop\Event\Dispatcher($eventBus);
    }
}
