<?php

require('config.php');
global $db, $t;

?>
<html>
    <?php print Admin::getHead(); ?>
    <body>
        <h1><?php print $t->get('appTitle'); ?> - Admin area</h1>


        <h2>System</h2>
        <table class="table1">
            <tr>
                <th>Environment</th>
                <td><?php print Gpf_Config::get('ENVIRONMENT'); ?></td>
            </tr>
            <tr>
                <th>Log-Level</th>
                <td><?php print Gpf_Config::get('LOG_LEVEL'); ?></td>
            </tr>
            <tr>
                <th>Current Servertime</th>
                <td><?php print Gpf_Config::get('NOW'). ' = '.date('d.m.Y H:i:s e-Z', Gpf_Config::get('NOW')); ?></td>
            </tr>
            <tr>
                <th>Memory usage of PHP</th>
                <td>
                    <?php
                        print (int)(memory_get_usage()/1024) . ' kB';
                        print '<br/>';
                        print (int)(memory_get_usage(true)/1024) . ' kB (real)';
                    ?>
                </td>
            </tr>
            <tr>
                <th>Loaded PHP-Extensions</th>
                <td style="width: 570px;">
                    <?php
                        $neededExtensions = array('apc', 'gd', 'xhprof', 'pdo_mysql', 'mbstring', 'session');
                        $extensions = get_loaded_extensions();
                        natcasesort($extensions);
                        foreach ($extensions as $ext) {
                            print '<div style="float:left; width:80px;">'.$ext.'</div>';
                        }
                        $missingExtensions = array();
                        foreach($neededExtensions as $ext) {
                            if (!in_array($ext, $extensions)) {
                                $missingExtensions[] = $ext;
                            }
                        }
                        if (count($missingExtensions) > 0) {
                            print '<div style="clear:both"></div><div class="error">Missing extensions: '.implode(',', $missingExtensions).'</div>';
                        }
                    ?>
                </td>
            </tr>
            <tr>
                <th>MySQL-Version</th>
                <td>
                    <?php
                        print $db->getVersion();
                    ?>
                </td>
            </tr>
            <tr>
                <th>MySQL-Status</th>
                <td>
                    <?php

                    $dbRes = $db->query('show status');
                    print '<table class="tableInvisible">';
                    foreach ($dbRes as $row) {
                        print '<tr>';
                        switch($row['Variable_name']) {
                            case 'Uptime':
                                print '<td>Uptime:</td><td>'.Admin::getInterval($row['Value'], 4).'</td>';
                                break;
                            case 'Max_used_connections':
                            case 'Slow_queries':
                            case 'Queries':
                                print '<td>'.$row['Variable_name'].':</td><td>'.$row['Value'].'</td>';
                                break;
                        }
                        print '</tr>';
                    }
                    print '</table>';
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>