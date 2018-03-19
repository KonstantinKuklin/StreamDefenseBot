<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class EndGameListener
{
    use ScreenRenderInjectTrait;

    /**
     * @param MessageEvent $event
     *
     * @throws \Exception
     */
    public function handle(MessageEvent $event)
    {
        $text = $event->getMessage()->text;
        $author = $event->getMessage()->author;
        $connection = $event->getConnection();
        $ttdBotNick = 'ttdbot';

        if ($author === $ttdBotNick) {
            $matches = [];
            \preg_match('/now in the lead!/ui', $text, $matches);
            if (!$matches) {
                return;
            }

            $this->screenRender->addLogRecord(new LogRecord(
                $event->getConnection()->getBotStatus()->nick,
                $event->getMessage(),
                'end of round',
                'clear stat'
            ));

            $botStatus = $connection->getBotStatus();
            $botStatus->class = null;
            $botStatus->isInGame = false;
            $botStatus->location = 'Map vote';
            $botStatus->lvl = 0;
            $botStatus->damage = null;
            $botStatus->criticalDamage = null;
            $botStatus->criticalChance = null;
            $botStatus->attackPeriod = null;
            $botStatus->attackRange = null;
            $botStatus->powerUp = false;
        }
    }
}
