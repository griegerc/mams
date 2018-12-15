<?php

	require('config.php');
	global $db;

?>
<html>
	<?php print Admin::getHead(); ?>
	<body>
		<h1>Table sizes of database "<?php print Gpf_Config::get('MYSQL_DATABASE'); ?>"</h1>
		<table class="table1">
            <thead>
                <tr>
                    <th>Table</th>
                    <th>Rows</th>
                    <th>Avg. row length (Bytes)</th>
                    <th>Data length (MByte)</th>
                    <th>Index length (kByte)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = '
                        SELECT
                            TABLE_NAME,
                            TABLE_ROWS,
                            AVG_ROW_LENGTH,
                            FLOOR(DATA_LENGTH/1024/1024) as DATA_LENGTH_MB,
                            FLOOR(INDEX_LENGTH/1024) as INDEX_LENGTH_KB
                        FROM information_schema.TABLES
                        WHERE TABLE_SCHEMA="'.Gpf_Config::get('MYSQL_DATABASE').'"
                        ORDER BY TABLE_NAME, DATA_LENGTH_MB DESC, INDEX_LENGTH_KB DESC, TABLE_ROWS DESC;';

                    $dbRes = $db->query($sql);
                    foreach ($dbRes as $dbRow) {
                        ?>
                        <tr>
                            <td><?php print $dbRow['TABLE_NAME']; ?></td>
                            <td style="text-align:right;"><?php print $dbRow['TABLE_ROWS']; ?></td>
                            <td style="text-align:right;"><?php print $dbRow['AVG_ROW_LENGTH']; ?></td>
                            <td style="text-align:right;"><?php print $dbRow['DATA_LENGTH_MB']; ?></td>
                            <td style="text-align:right;"><?php print $dbRow['INDEX_LENGTH_KB']; ?></td>
                        </tr>
                        <?php
                    }
                ?>
            </tbody>
		</table>
	</body>
</html>