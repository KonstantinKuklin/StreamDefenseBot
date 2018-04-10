<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Message;
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

        $gameCommandList = $this->getMessageToBotNick($event);
        if ($gameCommandList !== null) {
            $this->writeCommandListToEvent($event, (array)$gameCommandList);

            return;
        }

        $gameCommandList = $this->getMessageToBotGroup($event);
        if ($gameCommandList) {
            $this->writeCommandListToEvent($event, $gameCommandList);

            return;
        }
    }

    /**
     * @param MessageEvent $event
     *
     * @return array|null
     */
    private function getMessageToBotNick(MessageEvent $event)
    {
        $message = $event->getMessage();
        $botStatus = $event->getConnection()->getBotStatus();

        if ($message->commandForNick !== $botStatus->nick) {
            return null;
        }

        return $message->gameCommandList;
    }

    /**
     * @param MessageEvent $event
     *
     * @return array|null
     */
    private function getMessageToBotGroup(MessageEvent $event)
    {
        $message = $event->getMessage();
        $botStatus = $event->getConnection()->getBotStatus();

        if (!\is_array($message->commandForGroup)) {
            return null;
        }
        $gameCommandList = [];
        // for group
        foreach ($message->commandForGroup as $group => $commandList) {
            if ($group !== $botStatus->group) {
                continue;
            }
            $gameCommandList = \array_merge($gameCommandList, $commandList);
        }

        if (!$gameCommandList) {
            return null;
        }
        $this->screenRender->addLogRecord(new LogRecord(
            $event->getConnection()->getBotStatus()->nick,
            $message,
            'group command',
            \implode(' ', $gameCommandList)
        ));

        return $gameCommandList;
    }

    /**
     * @param MessageEvent $event
     * @param array        $gameCommandList
     */
    private function writeCommandListToEvent(MessageEvent $event, array $gameCommandList) : void
    {
        $message = $event->getMessage();
        $botStatus = $event->getConnection()->getBotStatus();

        // remove !leave command for not owner
        if ($message->author !== $botStatus->ownerNick) {
            if (($key = array_search(GameCommandMap::LEAVE, $gameCommandList)) !== false) {
                unset($gameCommandList[$key]);
            }
        }

        if ($message->gameCommandTar) {
            $gameCommandList[] = $message->gameCommandTar;
        }

        $whisperPrefix = '';
        if ($botStatus->preferWhisper) {
            $whisperPrefix = '/w ttdbot ';
        }

        $event->setTextToWrite($whisperPrefix . \implode(' ', $gameCommandList));
    }
}
