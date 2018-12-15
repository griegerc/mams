<?php

function adminer_object()
{
    require_once 'adminer/plugin.php';
    require_once 'adminer/plugin-frame.php';

    $plugins = array(
        new AdminerFrames
    );

    return new AdminerPlugin($plugins);
}

require './adminer/adminer-4.2.1.php';