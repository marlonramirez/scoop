<?php
namespace scoop\presistence;

class ObjectCollector {
	private static $totalObjects = array();
	private $objects = array();

	public function __construct () {
	}

	private static function notify (&$obj) {
		$object = self::internalSearch($obj, self::$totalObjects);
		if ($object) {
			return $object;
		}
		self::$totalObjects[] = $obj;
		return $obj;
	}

	private static function internalSearch (&$obj, &$type, $delete = FALSE) {
		foreach ($type as $key => &$object) {
			if ($obj == $object) {
				if ($delete) {
					unset($type[$key]);
				}
				return $object;
			}
		}
		return NULL;
	}

	public function search (&$obj) {
		return self::internalSearch($obj, $this->objects);
	}

	public function toArray () {
		return $this->objects;
	}

	public function add (&$obj) {
		$obj = self::notify($obj);
		$this->objects[] = $obj;
	}

	public function remove (&$obj) {
		self::internalSearch($obj, $this->objects, TRUE);
	}

	public function persist () {

	}
}