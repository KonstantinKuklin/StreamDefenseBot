<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;

class TargetPriorityListener
{
    /**
     * @param MessageEvent $event
     */
    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage()->message;
        $messageAuthor = $event->getMessage()->nick;

        if ($messageAuthor !== 'ttdbot') {
            return;
        }

        if (!\preg_match('/Target Sorting/ui', $message)) {
            return;
        }

        \sleep(1);
        $event->setTextToWrite($message);
    }
}
