<?php
namespace Scoop\Persistence;

class ObjectCollector
{
    private static $totalObjects = array();
    private static $fromDB = false;
    private $objects = array();

    public function __construct($array=array())
    {
        if ($array) {
            self::$fromDB = true;
            $this->objects = array_map(array($this, 'notify'), $array);
            self::$fromDB = false;
        }
    }

    private static function notify(&$obj)
    {
        $object = self::internalSearch($obj, self::$totalObjects);
        if ($object) {
            return $object;
        }
        self::$totalObjects[] = $obj;
        return $obj;
    }

    private static function internalSearch(&$obj, &$type, $delete = false)
    {
        foreach ($type as $key => &$object) {
            if ($obj == $object || (self::$fromDB && 
                get_class($obj) === get_class($object) && 
                $obj->getPK() === $object->getPK())) {
                if ($delete) {
                    unset($type[$key]);
                }
                return $object;
            }
        }
    }

    public function search(Model &$obj)
    {
        return array_search($obj, $this->objects);
    }

    public function toArray()
    {
        return $this->objects;
    }

    public function add(Model &$obj)
    {
        $obj = self::notify($obj);
        $this->objects[] = $obj;
    }

    public function get($i)
    {
        return $this->objects[$i];
    }

    public function remove(Model &$obj)
    {
        self::internalSearch($obj, $this->objects, true);
    }

    public function persist()
    {
    }
}
