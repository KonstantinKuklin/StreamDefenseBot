<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessageCommand;


use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class InitListener
{
    use ScreenRenderInjectTrait;

    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage();
        $botStatus = $event->getConnection()->getBotStatus();

        if ($message->author !== $botStatus->ownerNick) {
            return;
        }

        if (!isset($message->botCommandList[0]) || (isset($message->botCommandList[0]) && $message->botCommandList[0] !== '$init')) {
            return;
        }
        // message for concrete bot
        if ($message->commandForNick && $message->commandForNick !== $botStatus->nick) {
            return;
        }

        // message for concrete group
        if ($message->commandForGroup && $message->commandForGroup !== $botStatus->group) {
            return;
        }

        $command = $botStatus->classInited ? '!' . \ltrim($botStatus->classInited, '!') : GameCommandMap::BARD;
        $this->screenRender->addLogRecord(new LogRecord(
            $botStatus->nick,
            $event->getMessage(),
            'init',
            $command
        ));

        $event->setTextToWrite($command);
    }
}
