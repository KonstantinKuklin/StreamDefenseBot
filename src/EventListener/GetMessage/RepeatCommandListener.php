<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class RepeatCommandListener
{
    use ScreenRenderInjectTrait;

    /**
     * @param MessageEvent $event
     *
     * @throws \ReflectionException
     */
    public function handle(MessageEvent $event)
    {
        $botStatus = $event->getConnection()->getBotStatus();

        $author = $event->getMessage()->author;

        // follow only leader
        if ($author !== $botStatus->followTo) {
            return;
        }

        if (!$event->getMessage()->isCommandForGame) {
            // skip, because it was not a command
            return;
        }

        $allowedToRepeatCommand = \array_intersect($event->getMessage()->gameCommandList, GameCommandMap::ALLOWED_TO_REPEAT_MAP);
        if (!$allowedToRepeatCommand) {
            return;
        }
        if ($author !== $botStatus->ownerNick) {
            // Leave allowed just for owner
            $allowedToRepeatCommand = \array_diff($allowedToRepeatCommand, [GameCommandMap::LEAVE]);
        }

        $whisperPrefix = '';
        if ($botStatus->preferWhisper) {
            $whisperPrefix = '/w ttdbot ';
        }

        $command = $whisperPrefix . \implode(' ', $allowedToRepeatCommand);
        // repeat allowed commands here
        $event->setTextToWrite($command);

        $this->screenRender->addLogRecord(new LogRecord(
            $botStatus->nick,
            $event->getMessage(),
            'command to repeat',
            $command
        ));
    }
}
