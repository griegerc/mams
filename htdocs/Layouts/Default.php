<?php

class Layouts_Default extends Layouts_Abstract
{
    /**
     * @return string
     */
    protected function _getMetaData ()
    {
        $meta = '
            <meta name="viewport" content="width=device-width, initial-scale=1"/>
            <meta name="apple-mobile-web-app-capable" content="yes"/>
            <link rel="stylesheet" type="text/css" href="/css/main.css"/>
            <script type="text/javascript" src="/js/jquery.js"></script>
            <script type="text/javascript" src="/js/moment.js"></script>            
            <script type="text/javascript" src="/js/chart.js"></script>            
            <script type="text/javascript" src="/js/global.js"></script>
            <script type="text/javascript" src="/js/app.js"></script>';
        return $meta;
    }

    /**
     * Render layout
     * @return void
     */
    public function render()
    {
        App_Helper_Core::setResponseHeaders();
        print App_Helper_Core::getDocType();
        ?>
            <html>
                <head>
                    <?php print App_Helper_Core::getMetaData(); ?>
                    <?php print $this->_getMetaData(); ?>
                </head>
                <body>
                    <h1><?php print $this->t->get('appTitle'); ?></h1>
                    <?php
                        $actionName = $this->_action;
                        $this->view->$actionName();
                    ?>
                </body>
            </html>
        <?php
    }
}