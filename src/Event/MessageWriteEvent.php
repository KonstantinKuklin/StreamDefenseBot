<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Event;


use KonstantinKuklin\StreamDefenseBot\Config\ConnectionConfig;
use KonstantinKuklin\StreamDefenseBot\Message;
use Symfony\Component\EventDispatcher\Event;

class MessageWriteEvent extends MessageEvent
{
    public function __construct(Message $message, ConnectionConfig $connection)
    {
        parent::__construct($message, $connection);
    }
}
