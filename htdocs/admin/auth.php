<?php

if (!isset($_SERVER['PHP_AUTH_USER']) || trim($_SERVER['PHP_AUTH_USER'])=='') {
    header('WWW-Authenticate: Basic realm="Administration Area"');
    header('HTTP/1.0 401 Unauthorized');
    exit ('Unauthorized');
}
if (!isset($_SERVER['PHP_AUTH_PW'])) {
    unset($_SERVER['PHP_AUTH_USER']);
    header('HTTP/1.0 401 Unauthorized');
    exit ('Unauthorized');
}
if ($_SERVER['PHP_AUTH_USER'] == Gpf_Config::get('ADMIN_USERNAME') && $_SERVER['PHP_AUTH_PW'] == Gpf_Config::get('ADMIN_PASSWORD')) {
    // authorized
} else {
    unset($_SERVER['PHP_AUTH_USER']);
    unset($_SERVER['PHP_AUTH_PW']);
    header('HTTP/1.0 401 Unauthorized');
    exit ('Unauthorized');
}