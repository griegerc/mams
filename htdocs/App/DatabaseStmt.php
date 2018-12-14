<?php

class App_DatabaseStmt
{
    public static $sqlStatements = array(

        'getGames' =>
            'SELECT DISTINCT `gameId` FROM `measureTypes` ORDER BY `gameId`;',

        'getMeasureTypes' =>
            'SELECT * FROM `measureTypes` WHERE `gameId` = ? GROUP BY `measureKey` ORDER BY `measureKey`;',

        'getMeasureType' =>
            'SELECT * FROM `measureTypes` WHERE `gameId` = ? AND `measureKey` = ?;',

        'insertMeasureType' =>
            'INSERT INTO `measureTypes` (`gameId`, `measureKey`) VALUES (?, ?);',



        'insertMeasureData' =>
            'INSERT INTO `measureData` (`dataTime`, `measureTypeId`, `value`) VALUES (?, ?, ?);',

        'getMeasureData' =>
            'SELECT * FROM `measureData` WHERE `measureTypeId` = ? AND `dataTime` >= ?;'
    );
}