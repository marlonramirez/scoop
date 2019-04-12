<?php
namespace Scoop\Validation;

/**
 * Clase base para establecer reglas de validación
 */
abstract class Rule
{
    /**
     * Campos que seran validados.
     * @var array
     */
    private $fields;
    protected $values;

    /**
     * Genera la estructura necesaria para la regla
     * @param string  $name          Nombre de la regla
     * @param array  $fields        Campos a ser validados
     * @param array   $params        Párametros de apoyo
     * @param boolean $includeInputs Posee inputs "hermanos"
     */
    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    /**
     * Obtiene los campos que estan siendo validados
     * @return array Campos validados
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Obtiene los párametros de apoyo (max, min, etc)
     * @return array Párametros de apoyo
     */
    public function getParams()
    {
        $params = get_object_vars($this);
        return $params;
    }

    /**
     * Obtiene el nombre de la regla
     * @return string Nombre de la regla
     */
    public function getName()
    {
        $className = get_class($this);
        $baseClass = substr(strrchr($className, '\\'), 1);
        return lcfirst($baseClass);
    }

    /**
     * Convierte los inputs "Hermanos" que son enviados como parametros.
     * @param  string|array $inputs Nombre del campo o campos a ser convertido.
     */
    public function setValues($data)
    {
        if (!isset($this->inputs)) return;
        $this->values = array();
        if (is_array($this->inputs)) {
            foreach ($this->inputs as $key => $value) {
                $this->values[$value] = is_numeric($key) ? $data[$value] : $data[$key];
            }
            return;
        }
        $this->values = array($this->inputs => $data[$this->inputs]);
    }

    /**
     * Valida si se cumple o no con la condición configurada por la clase
     * hija
     * @param  array $params Párametros enviados para la validación (apoyo+valor)
     * @return boolean          Pasa o no la validación
     */
    abstract public function validate($value);
}
