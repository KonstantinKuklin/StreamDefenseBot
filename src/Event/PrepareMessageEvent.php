<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Event;

use Symfony\Component\EventDispatcher\Event;

class PrepareMessageEvent extends Event
{
    private $originalMessage;

    private $skip = false;

    public function __construct($originalMessage)
    {
        $this->originalMessage = $originalMessage;
    }

    public function getOriginalMessage()
    {
        return $this->originalMessage;
    }

    public function shouldSkip()
    {
        $this->skip = true;
        $this->stopPropagation();
    }

    public function isSkip()
    {
        return $this->skip;
    }
}
