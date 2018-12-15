<?php

require dirname(dirname(dirname(__FILE__))) . '/Gpf/init.php';
$db = Gpf_Database::getInstance();

$data = array(
    array('userLogin',   4),
    array('questStatus', 4),
    array('userLogin', 5),
    array('questStatus', 5),
    array('gameValue', 5)
);

foreach ($data as $set) {
    $key = $set[0];
    $gameId = $set[1];

    $db->execute('INSERT INTO `measureTypes` (`measureKey`, `gameId`) VALUES("'.$key.'", '.$gameId.');');
    $typeId = $db->getLastInsertedId();

    $v = mt_rand(-100, 1000);
    for($i=0; $i<5000; $i++) {
        $t = time() - $i*300 - mt_rand(0, 30);
        $v += mt_rand(-10, 10);
        $db->execute('INSERT INTO `measureData` (`dataTime`, `measureTypeId`, `value`) VALUES('.$t.', '.$typeId.', '.$v.');');
    }
}