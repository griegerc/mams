<?php

class Gpf_Translation
{
    /** @var string */
    private $_language;

    /** @var array - stored translations texts/keys */
    private $_translation = array();

    /** @var Gpf_Translation */
    private static $_instance = NULL;

    /**
     * Instance
     * @return Gpf_Translation
     */
    public static function getInstance()
    {
        if (NULL === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Sets a new language for all translations
     * @param string $language
     */
    public function setLanguage($language)
    {
        $filename = GPF_BASEPATH.'/translation/'.strtolower($language).'.ini';
        if (file_exists($filename)) {
            $this->_translation = parse_ini_file($filename);
        }
    }

    /**
     * Fetches the path of the translation to load
     * @return string
     */
    private function _getSourcePath()
    {
        return GPF_BASEPATH.'/translation/'.strtolower($this->_language).'.ini';
    }

    /**
     * Prohibited constructor
     * @param string $language
     */
    private function __construct($language = '')
    {
        $this->_language = Gpf_Config::get('LANGUAGE');
        $this->_translation = parse_ini_file($this->_getSourcePath());
    }

    private function __clone() {}

    /**
     * Checks wether a specific translation key is translated
     * @param string $translationKey
     * @return bool
     */
    private function _isTranslated($translationKey)
    {
        if (isset($this->_translation[$translationKey])) {
            return true;
        }
        return false;
    }

    /**
     * Retrieves an translation string by a given key.
     * @param string $translationKey
     * @param array $replacements
     * @return string
     */
    public function get($translationKey, $replacements = array())
    {
        if (!$this->_isTranslated($translationKey)) {
            Gpf_Logger::warn('Key "'.$translationKey.'" not translated in language "'.$this->_language.'"', 'TRANSLATION');
            return '!!!'.$translationKey.'!!!';
        } else {
            $trText = $this->_translation[$translationKey];

            /**
             * Replacements
             */
            if (is_array($replacements) && count($replacements)>0) {
                foreach ($replacements as $replKey => $replValue) {
                    $trText = str_replace('%%'.$replKey.'%%', $replValue, $trText);
                }
            }

            return $trText;
        }
    }
}