<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class ClassChangeListener
{
    use ScreenRenderInjectTrait;

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

        $commandList = $message->gameCommandList;
        $classCommandList = \array_intersect($commandList, GameCommandMap::CLASS_MAP);
        if (!$classCommandList) {
            return;
        }

        $class = \ucfirst(trim(\array_pop($classCommandList), '!'));
        $botStatus->class = $class;

        $this->screenRender->addLogRecord(new LogRecord(
            $event->getConnection()->getBotStatus()->nick,
            $message,
            'change class',
            'class to ' . $class
        ));
    }
}
