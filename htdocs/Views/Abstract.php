<?php

abstract class Views_Abstract
{
    /** @var Gpf_Translation */
    public $t;

    /** @var array */
    public $env;

    /** @var string */
    public $action;

    /**
     * Constructor
     * @param array $env
     */
    public function __construct($env)
    {
        $this->t = Gpf_Translation::getInstance();
        $this->env = $env;
        $this->action = Gpf_Core::getCamelCased($this->env[Gpf_Core::PARAM_ACTION]);
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
     * Default action
     * @return void
     */
    public function indexAction()
    {
    }
}