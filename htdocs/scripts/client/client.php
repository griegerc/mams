<?php

/**
 * Propose for a measuring client class
 */
class Measuring
{
    /** @var string */
    private $_host;

    /** @var int */
    private $_port;

    /** @var int */
    private $_gameId;

    /**
     * Measuring constructor
     * @param string $host
     * @param int $port
     * @param int $gameId
     */
    public function __construct($host, $port, $gameId)
    {
        $this->_host = $host;
        $this->_port = (int)$port;
        $this->_gameId = (int)$gameId;
    }

    /**
     * Increments a specific metric by "1"
     * @param string $metric
     */
    public function inc($metric)
    {
        $this->add($metric, 1);
    }

    /**
     * Adds a value to a specific metric
     * @param string $metric
     * @param int $value
     */
    public function add($metric, $value)
    {
        $this->_send($metric, $value);
    }

    /**
     * Sends metric data to the MAMS server
     * @param string $metric
     * @param int $value
     */
    private function _send($metric, $value)
    {
        $data = array(
            'gameId' => $this->_gameId,
            'key'    => $metric,
            'value'  => $value
        );

        $socket = fsockopen('udp://'.$this->_host.':'.$this->_port);
        fputs($socket, json_encode($data));
    }
}



/**
 * DEMO for the client
 */
$host   = '192.168.182.129';
$port   = 41234;
$gameId = 19;

$m = new Measuring($host, $port, $gameId);

echo 'Incrementing metric "userLogin"...';
$m->inc('userLogin');
echo 'ok' . PHP_EOL;

echo 'Sleepting 3s...';
sleep(3);
echo 'ok' . PHP_EOL;

echo 'Incrementing metric "questReward"...';
$m->add('questReward', 25);
echo 'ok' . PHP_EOL;

echo 'Sleepting 3s...';
sleep(3);
echo 'ok' . PHP_EOL;

// testing maximal key length
echo 'Incrementing metric "klingDongTrislosRichtongSochtung"...';
$m->add('klingDongTrislosRichtongSochtung', 215);
echo 'ok' . PHP_EOL;