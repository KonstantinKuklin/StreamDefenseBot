<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service\Irc;


use Phergie\Irc\Client\React\Client;
use Phergie\Irc\ConnectionInterface;

class MyClient extends Client
{
    protected function getWriteStream(ConnectionInterface $connection)
    {
        $write = new MyWriteStream();
        $this->addLogging($write, $connection);
        return $write;
    }

    protected function getReadStream(ConnectionInterface $connection)
    {
        $read = new MyReadStream();
        $this->addLogging($read, $connection);
        $read->on('invalid', $this->getOutputLogCallback($connection, 'notice', 'Parser unable to parse line: '));
        return $read;
    }
}
