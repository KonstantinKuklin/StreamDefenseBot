<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class StartGameListener
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

        if ($author === 'ttdbot') {
            $matches = [];
            \preg_match('/WAVE 1 SENT. Next:/ui', $text, $matches);
            if (!$matches) {
                return;
            }

            $this->screenRender->addLogRecord(new LogRecord(
                $event->getConnection()->getBotStatus()->nick,
                $event->getMessage(),
                'start round',
                ''
            ));

            if ($connection->getBotStatus()->autoStartInGame) {
                $class = $connection->getBotStatus()->classInited;
                $event->setTextToWrite('!' . \ltrim($class, '!'));
            }
        }
    }
}
