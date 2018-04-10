<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class IgnoreMessageListener
{
    /**
     * @param MessageEvent $event
     *
     * @throws \Exception
     */
    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage();
        $author = $event->getMessage()->author;
        $connection = $event->getConnection();

        if ($author !== $connection->getBotStatus()->followTo) {
            return;
        }

        if ($message->hasIgnoreAttribute) {
            $event->ignoreWrite();
        }
    }
}
