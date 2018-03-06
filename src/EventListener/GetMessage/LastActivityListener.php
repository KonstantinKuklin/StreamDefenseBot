<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;
use KonstantinKuklin\StreamDefenseBot\TickPinger;

class LastActivityListener
{
    use ScreenRenderInjectTrait;

    /**
     * @var TickPinger
     */
    private $tickPinger;

    public function __construct(TickPinger $tickPinger)
    {
        $this->tickPinger = $tickPinger;
    }

    /**
     * @param MessageEvent $event
     *
     * @throws \Exception
     */
    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage();
        $botStatus = $event->getConnection()->getBotStatus();

        if ($message->author !== $botStatus->nick) {
            return;
        }
        if (!$message->isCommandForGame) {
            return;
        }

        // update last interval for
        $this->tickPinger->update($message->author);
        $botStatus->lastActivity = time();

        $this->screenRender->addLogRecord(new LogRecord(
            $botStatus->nick,
            $message,
            'activity',
            'update timers'
        ));
    }
}
