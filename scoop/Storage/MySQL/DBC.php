<?php
namespace Scoop\Storage\MySQL;

class DBC extends \Mysqli
{
    private static $instances = array();

    /*constructor*/
    private function __construct($db, $user, $pass, $host)
    {
        parent::__construct($host, $user, $pass, $db) or die($this->connect_error);
        //selecciona el cotejamiento de la base de datos
        $this->query('SET NAMES \'utf8\'');
    }

    private function __clone() {}

    public static function get($conf = null)
    {
        $bundle = 'db.default';
        if (is_string($conf)) {
            $bundle = $conf;
        }
        $config = \Scoop\Bootstrap\Config::get($bundle);
        if (is_array($conf)) {
            $config += $conf;
        }
        $key = implode('', $config);

        if (!isset(self::$instances[$key])) {
            self::$instances[$key] = new DBCmySQL(
                $config['database'],
                $config['user'],
                $config['password'],
                $config['host']
            );
        }
        return self::$instances[$key];
    }

}
