<?php

class App_Helper_Core
{
    /**
     * Sets all response headers.
     * @return void
     */
    public static function setResponseHeaders()
    {
        header('Cache-control: no-cache');
        header('Expires: '.GMDate('D, d M Y H:i:s').' GMT');
        header('Expires: now');
        header('Pragma: no-cache');
        header('Content-Type: text/html; charset=utf-8');
    }

    /**
     * Returns the default HTML meta data.
     * @return string
     */
    public static function getDocType()
    {
        return '<!DOCTYPE html>';
    }

    /**
     * Returns the default HTML meta data.
     * @return string
     */
    public static function getMetaData()
    {
        $t = Gpf_Translation::getInstance();

        return '
            <title>'.$t->get('appTitle').'</title>
            <meta charset="utf-8" />
            <meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
    }

    /**
     * Returns a link for a given command/action set and optional parameters.
     * @param string $text
     * @param string $controller
     * @param bool|false|string $action
     * @param array|bool|false $params
     * @param array|bool|false $classNames
     * @param bool $optSpan
     * @param bool $title
     * @return string
     */
    public static function getLink($text, $controller, $action = false,
              $params = false, $classNames = false, $optSpan = false, $title = false)
    {
        $url = Gpf_Core::getURL($controller, $action, $params);
        $class = '';
        if ($classNames !== false) {
            $class = ' class="'.$classNames.'"';
        }
        if ($title == true) {
            $title = ' title="'.$text.'"';
            $text = '';
        }
        if ($optSpan === true) {
            return '<a href="'.$url.'"'.$class.$title.'><span>'.$text.'</span></a>';
        } else {
            return '<a href="'.$url.'"'.$class.$title.'>'.$text.'</a>';
        }
    }

    /**
     * Renders an javascript link
     * @param string $linkContent
     * @param string $jsEvent
     * @param array $params
     * @param string $classNames
     * @param bool $title
     * @param string $cssStyle
     * @return string
     */
    public static function getJavascriptLink($linkContent, $jsEvent, $params = array(), $classNames = '', $title = false, $cssStyle = '')
    {
        $jsData = '';
        if (count($params) > 0) {
            foreach($params as $param) {
                $jsData .= 'jsData:'.urlencode($param).' ';
            }
        }
        if ($title == true) {
            $title = ' title="'.$linkContent.'"';
            $linkContent = '';
        }

        $cssStyle = ($cssStyle != '')?' style="'.$cssStyle.'"':'';
        return sprintf('<a href="javascript:void(0);" class="jsClick jsEvent:%s %s %s"%s%s>%s</a>',
            $jsEvent,
            $jsData,
            $classNames,
            $title,
            $cssStyle,
            $linkContent
        );
    }
}