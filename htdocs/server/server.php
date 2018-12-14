<?php

if (php_sapi_name() != "cli") {
    exit('Run this script only in CLI mode!');
}

require dirname(dirname(__FILE__)) . '/Gpf/init.php';

/**
 * Assembles and returns a socket error message
 * @return string
 */
function getSocketError()
{
    $errorCode = socket_last_error();
    $errorMessage = socket_strerror($errorCode);
    return 'Socket-Error #' . $errorCode . ': ' . $errorMessage;
}

/**
 * Tries to insert new measurement data into the database
 * @param string $rawData
 */
function insertMeasureData($rawData)
{
    $db = Gpf_Database::getInstance();
    if ($rawData === false) {
        Gpf_Logger::error(getSocketError(), 'UDP-SERVER');
        return;
    }

    $data = json_decode($rawData, true);
    if (!isset($data['gameId']) || !isset($data['key']) || !isset($data['value'])) {
        Gpf_Logger::error('Invalid params: '.var_export($rawData, true), 'UDP-SERVER');
        return;
    }
    $gameId = (int)$data['gameId'];
    if ($gameId <= 0 || $gameId > 255) {
        Gpf_Logger::error('Invalid gameId', 'UDP-SERVER');
        return;
    }

    $measureKey = Gpf_Core::trimAndCleanString($data['key']);
    if (strlen($measureKey) <= 0 || strlen($measureKey) > 32) {
        Gpf_Logger::error('Invalid key length', 'UDP-SERVER');
        return;
    }
    $dbParams = array($gameId, $measureKey);
    $dbRes = $db->inquiryOne('getMeasureType', $dbParams);

    if (!isset($dbRes['measureTypeId'])) {
        $db->inquiry('insertMeasureType', $dbParams);
        $measureTypeId = $db->getLastInsertedId();
    } else {
        $measureTypeId = (int)$dbRes['measureTypeId'];
    }
    if ($measureTypeId === 0) {
        Gpf_Logger::error('Invalid measureTypeId', 'UDP-SERVER');
        return;
    }

    $value = (int)$data['value'];
    $db->inquiry('insertMeasureData', array(time(), $measureTypeId, $value));
}


echo 'Starting MAMS server...';
$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
if (!$socket) {
    Gpf_Logger::error(getSocketError(), 'UDP-SERVER');
    exit(1);
}
if (!socket_bind($socket, Gpf_Config::get('SERVER_HOST'), Gpf_Config::get('SERVER_PORT'))) {
    Gpf_Logger::error(getSocketError(), 'UDP-SERVER');
    exit(2);
}
echo '[ok]' . PHP_EOL;
echo 'Listening to port ' . Gpf_Config::get('SERVER_PORT') . '...' . PHP_EOL;

$startTime = microtime(true);
$runTime = (int)Gpf_Config::get('SERVER_MAX_RUNTIME');
while (true) {
    $rawData = socket_read($socket, 512);
    insertMeasureData($rawData);

    if ((microtime(true) - $startTime) > $runTime) {
        Gpf_Logger::info('Exited server after ' . $runTime . ' seconds runtime.', 'UDP-SERVER');
        break;
    }
}