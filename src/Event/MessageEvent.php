<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Event;


use KonstantinKuklin\StreamDefenseBot\Config\ConnectionConfig;
use KonstantinKuklin\StreamDefenseBot\Message;
use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends Event
{
    /**
     * @var Message
     */
    private $message;

    private $textToWrite;

    /**
     * @var ConnectionConfig
     */
    private $connection;
    private $trace;

    public function __construct(Message $message, ConnectionConfig $connection)
    {
        $this->message = $message;
        $this->connection = $connection;
    }

    /**
     * @return ConnectionConfig
     */
    public function getConnection() : ConnectionConfig
    {
        return $this->connection;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    public function hasTextToWrite()
    {
        return null !== $this->textToWrite;
    }

    /**
     * @param string|null $text
     */
    public function setTextToWrite($text)
    {
        $e = new \Exception();
        $e->getTrace();
        $this->trace = $e->getTrace();

        $this->textToWrite = $text;
        $this->stopPropagation();
    }

    /**
     * @return string|null
     */
    public function getTextToWrite()
    {
        return $this->textToWrite;
    }
}
