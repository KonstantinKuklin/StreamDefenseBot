<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class ChangeLocationListener
{
    use ScreenRenderInjectTrait;

    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage();
        $botStatus = $event->getConnection()->getBotStatus();

        // bot had has movement
        if ($message->author !== $botStatus->nick) {
            return;
        }

        $commandList = $message->gameCommandList;
        $locationCommandList = \array_intersect($commandList, GameCommandMap::CHANGE_LOCATION_MAP);
        if (!$locationCommandList) {
            return;
        }

        $i = 0;
        while ($locationCommandList) {
            $i++;
            $command = \array_pop($locationCommandList);
            if (\in_array($command, [GameCommandMap::ALTAR_SHORT, GameCommandMap::ALTAR])) {
                continue;
            }

            if ($command === GameCommandMap::TRAIN_SHORT) {
                $command = GameCommandMap::TRAIN;
            }
            $location = \ucfirst(trim($command, '!'));
            if (\is_numeric($location)) {
                $location = 'Tower ' . $location;
            }

            $botStatus->location = $location;
            if (!$botStatus->class) {
                $botStatus->class = 'unknown';
            }

            $this->screenRender->addLogRecord(new LogRecord(
                $botStatus->nick,
                $message,
                'change location',
                'location to ' . $location
            ));

            if ($i > 6) {
                break;
            }
        }
    }
}
