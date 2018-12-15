<?php

require_once('config.php');

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Admin area</title>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <link rel="stylesheet" type="text/css" href="css/nav.css"/>
    </head>
    <body>
        <h2>Maintenance</h2>
        <ul>
            <li><a target="main" href="main.php">Main</a></li>
            <li><a target="main" href="php/php_info.php">PHP-Info</a></li>
            <li><a target="main" href="php/php_constants.php">PHP-Constants</a></li>
            <li><a target="main" href="php/php_vars.php">PHP-Variables</a></li>
            <li><a target="main" href="php/php_apc.php">APC</a></li>
        </ul>

        <h2>MySQL</h2>
        <ul>
            <li><a target="main" href="adminer.php">Adminer</a></li>
            <li><a target="main" href="mysql_tables.php">Tables</a></li>
        </ul>
    </body>
</html>