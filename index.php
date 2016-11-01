<?php
/**
 * Scoop (Simple Characteristics of Object Oriented PHP) apoya el uso de convenciones PSR (http://www.php-fig.org/psr/).
 * StudlyCaps: Clases, Interfaces, Namespaces, Packages
 * camelCase: Métodos, Propiedades, Párametro, Variable
 * ALL_CAPS: Constantes
 *
 * @package Scoop
 * @license http://opensource.org/licenses/MIT MIT
 * @author  Marlon Ramírez <marlonramirez@outlook.com>
 * @link http://getscoop.org
 * @version 0.4
 */

try {
    require 'scoop/Bootstrap/Loader.php';
    $environment = new \App\Production();
    $app = new \Scoop\Bootstrap\Application($environment);
    $app->run();
} catch (\Scoop\Http\Exception $ex) {
    $ex->handler();
}
