<?php

abstract class Layouts_Abstract
{
    /** @var Gpf_Translation */
    public $t;

    /** @var array */
    public $env;

    /** @var Views_Abstract */
    public $view;

    /** @var string */
    protected $_controller;

    /** @var string */
    protected $_action;

    /**
     * Constructor
     * @param array $env
     * @param Views_Abstract $view
     */
    public function __construct($env, Views_Abstract $view)
    {
        $this->t = Gpf_Translation::getInstance();
        $this->env = $env;
        $this->view = $view;
        if (isset($env[Gpf_Core::PARAM_ACTION])) {
            $this->_action = Gpf_Core::getCamelCased((string)$env[Gpf_Core::PARAM_ACTION]);
        }
        if (isset($env[Gpf_Core::PARAM_CONTROLLER])) {
            $this->_controller = Gpf_Core::getCamelCased((string)$env[Gpf_Core::PARAM_CONTROLLER]);
        }
    }

    /**
     * Fetches the content of a env param
     * @param string $paramKey
     * @param mixed $defaultValue
     * @return mixed
     */
    protected function _getParam($paramKey, $defaultValue = NULL)
    {
        if (isset($this->env[$paramKey])) {
            return $this->env[$paramKey];
        } else {
            return $defaultValue;
        }
    }

    /**
     * @return string
     */
    protected abstract function _getMetaData();

    /**
     * @return void
     */
    public abstract function render();
}