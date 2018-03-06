<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service;


use KonstantinKuklin\StreamDefenseBot\Message;

class LogRecord
{
    private $botName;

    private $whatFound;

    private $action;

    private $createdAt;

    /**
     * @var Message
     */
    private $message;

    public function __construct($botName, Message $message, $whatFound, $action)
    {
        $this->botName = $botName;
        $this->whatFound = $whatFound;
        $this->action = $action;
        $this->createdAt = time();
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getBotName()
    {
        return $this->botName;
    }

    /**
     * @return Message
     */
    public function getMessage() : Message
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getWhatFound()
    {
        return $this->whatFound;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return int
     */
    public function getCreatedAt() : int
    {
        return $this->createdAt;
    }
}
