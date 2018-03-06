<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\PrepareMessage;

use KonstantinKuklin\StreamDefenseBot\Event\PrepareMessageEvent;

class WrongCommandListener
{
    private $allowedCommand = ['PRIVMSG', 'WHISPER'];

    public function handle(PrepareMessageEvent $event)
    {
        $message = $event->getOriginalMessage();
        if (!\in_array($message['command'], $this->allowedCommand, true)) {
            $event->shouldSkip();
        }
    }
}
