<?php

abstract class Controllers_Abstract extends App_Base
{
    /** @var array */
    public $env;

    /** @var string */
    public $layout;

    /** @var bool */
    public $renderView;

    /**
     * Constructor
     * @param array $env
     */
    public function __construct($env)
    {
        $this->layout = 'Default';
        $this->renderView = true;
        $this->env = $env;
        $this->_auth();
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
     * Authenticates the user
     * @return bool
     */
    protected function _auth()
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) || trim($_SERVER['PHP_AUTH_USER']) == '') {
            header('WWW-Authenticate: Basic realm="MAMS Analyzing"');
            header('HTTP/1.0 401 Unauthorized');
            exit('Unauthorized');
        }
        if (!isset($_SERVER['PHP_AUTH_PW'])) {
            unset($_SERVER['PHP_AUTH_USER']);
            header('HTTP/1.0 401 Unauthorized');
            exit('Unauthorized');
        }
        if ($_SERVER['PHP_AUTH_USER'] == Gpf_Config::get('APP_USERNAME') && $_SERVER['PHP_AUTH_PW'] == Gpf_Config::get('APP_PASSWORD')) {
            return true;
        } else {
            unset($_SERVER['PHP_AUTH_USER']);
            unset($_SERVER['PHP_AUTH_PW']);
            header('HTTP/1.0 401 Unauthorized');
            exit('Unauthorized');
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