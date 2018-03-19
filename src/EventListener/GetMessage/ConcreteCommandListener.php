<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class ConcreteCommandListener
{
    use ScreenRenderInjectTrait;

    /**
     * @param MessageEvent $event
     *
     * @throws \ReflectionException
     */
    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage();
        $botStatus = $event->getConnection()->getBotStatus();

        // follow only ownerNick and leader
        if (!\in_array($message->author, [$botStatus->followTo, $botStatus->ownerNick], true)) {
            return;
        }

        $gameCommandLits = $message->gameCommandList;
        // remove !leave command for not owner
        if ($message->author !== $botStatus->ownerNick) {
            if (($key = array_search(GameCommandMap::LEAVE, $gameCommandLits)) !== false) {
                unset($gameCommandLits[$key]);
            }
        }

        if ($message->gameCommandTar) {
            $gameCommandLits[] = $message->gameCommandTar;
        }

        if (!$gameCommandLits) {
            return;
        }

        // for group
        if ($message->commandForGroup === $botStatus->group) {
            $event->setTextToWrite(\implode(' ', $gameCommandLits));

            $this->screenRender->addLogRecord(new LogRecord(
                $event->getConnection()->getBotStatus()->nick,
                $message,
                'group command',
                \implode(' ', $gameCommandLits)
            ));

            return;
        }

        // for this bot
        if ($message->commandForNick === $botStatus->nick) {
            $event->setTextToWrite(\implode(' ', $gameCommandLits));

            $this->screenRender->addLogRecord(new LogRecord(
                $event->getConnection()->getBotStatus()->nick,
                $message,
                'bot command',
                \implode(' ', $gameCommandLits)
            ));

            return;
        }
    }
}
