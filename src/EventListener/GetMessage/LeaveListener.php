<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class LeaveListener
{
    use ScreenRenderInjectTrait;

    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage();
        $botStatus = $event->getConnection()->getBotStatus();

        if (!$message->isCommandForGame) {
            return;
        }
        if ($message->author !== $botStatus->nick) {
            return;
        }

        $commandList = $message->gameCommandList;
        $classCommandList = \array_intersect($commandList, [GameCommandMap::LEAVE]);
        if (!$classCommandList) {
            return;
        }

        $botStatus->isLeft = true;
    }
}
