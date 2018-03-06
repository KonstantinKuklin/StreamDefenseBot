<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class PowerChangeListener
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
        $classCommandList = \array_intersect($commandList, [GameCommandMap::POWER_UP, GameCommandMap::POWER_DOWN]);
        if (!$classCommandList) {
            return;
        }

        // set class means that we are in game TODO add isInGame variable for it
        if (!$botStatus->class) {
            $botStatus->class = 'unknown';
        }

        $lastCommand = \array_pop($classCommandList);
        if ($lastCommand === GameCommandMap::POWER_UP) {
            $botStatus->powerUp = 'On';

            $this->screenRender->addLogRecord(new LogRecord(
                $botStatus->nick,
                $message,
                'power up',
                ''
            ));
        } else {
            $botStatus->powerUp = null;

            $this->screenRender->addLogRecord(new LogRecord(
                $botStatus->nick,
                $message,
                'power down',
                ''
            ));
        }
    }
}
