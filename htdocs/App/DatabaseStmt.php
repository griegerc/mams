<?php

class App_DatabaseStmt
{
    public static $sqlStatements = array(

        'getMeasureType' =>
            'SELECT * FROM `measureTypes` WHERE `gameId` = ? AND `measureKey` = ?;',

        'insertMeasureType' =>
            'INSERT INTO `measureTypes` (`gameId`, `measureKey`) VALUES (?, ?);',



        'insertMeasureData' =>
            'INSERT INTO `measureData` (`dataTime`, `measureTypeId`, `value`) VALUES (?, ?, ?);'
    );
}