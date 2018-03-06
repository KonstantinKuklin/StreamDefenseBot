<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Config;

use KonstantinKuklin\StreamDefenseBot\Service\BotStatus;
use Phergie\Irc\Connection;

class ConnectionConfig extends Connection
{
    /**
     * @return BotStatus
     */
    public function getBotStatus() : BotStatus
    {
        return $this->getOption('status');
    }
}
