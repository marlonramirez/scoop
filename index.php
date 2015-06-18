<?php
/**
 * Scoop (Simple Characteristics of Object Oriented PHP) apoya el uso de convenciones PSR.
 * Clases/Interfaces: PascalCase <http://localhost/class-to-pascal-case/>
 * Métodos: camelCase <http://localhost/class-to-pascal-case/method-to-camel-case/>
 * Constantes: ALL_CAPS
 * Namespaces/Packages: PascalCase
 * Propiedades/Párametro/Variable: camelCase
 *
 * @package scoop
 * @license http://opensource.org/licenses/MIT MIT
 * @author  Marlon Ramírez <marlonramirez@outlook.com>
 * @link http://getscoop.org
 * @version 0.1.3 Estabilización de estandares PSR
 */

try {
    require 'scoop/Bootstrap/Loader.php';
    Loader::get();
    \Scoop\Bootstrap\Config::add('app/config');
    \Scoop\Bootstrap\App::run();
} catch (\Scoop\Http\Exception $ex) {
    $ex->handler();
}
