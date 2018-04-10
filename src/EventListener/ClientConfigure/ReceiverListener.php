<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure;

use KonstantinKuklin\StreamDefenseBot\Config\ConnectionConfig;
use KonstantinKuklin\StreamDefenseBot\Event\ClientConfigureEvent;
use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Event\MessageWriteEvent;
use KonstantinKuklin\StreamDefenseBot\Event\PrepareMessageEvent;
use KonstantinKuklin\StreamDefenseBot\Message;
use KonstantinKuklin\StreamDefenseBot\MessageParser;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\TickPinger;
use Phergie\Irc\Client\React\WriteStream;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ReceiverListener
{
    /**
     * @var TickPinger
     */
    protected $tickPinger;

    /**
     * @var EventDispatcher
     */
    protected $dispatcher;

    protected $channel;

    /**
     * @param ClientConfigureEvent $clientConfigureEvent
     *
     * @throws \InvalidArgumentException
     */
    public function handle(ClientConfigureEvent $clientConfigureEvent)
    {
        $this->tickPinger = $clientConfigureEvent->getApplication()->getTickPinger();
        $this->channel = $clientConfigureEvent->getApplication()->getGameConfig()->getChannel();
        $this->dispatcher = $clientConfigureEvent->getApplication()->getEventDispatcher();

        $client = $clientConfigureEvent->getClient();

        $callback = $this->getCallback();
        $client->on('irc.received', $callback);
    }

    private function getCallback()
    {
        return function ($message, WriteStream $write, ConnectionConfig $connection, LoggerInterface $logger) {
            $prepareEvent = new PrepareMessageEvent($message);
            $this->dispatcher->dispatch('message.prepare', $prepareEvent);
            if ($prepareEvent->isSkip()) {
                return;
            }

            $messageParsed = MessageParser::getParsedMessage($message['message']);
            $messageGetEvent = new MessageEvent($messageParsed, $connection);
            $this->dispatcher->dispatch('message.get', $messageGetEvent);

            if (!$messageGetEvent->hasTextToWrite()) {
                return;
            }

            if ($messageGetEvent->shouldIgnoreWrite()) {
                return;
            }

            // update stats like this message will come from IRC server
            $messageToWrite = new Message();
            $messageToWrite->author = $connection->getBotStatus()->nick;
            $messageToWrite->text = $messageGetEvent->getTextToWrite();
            $messageToWrite->gameCommandList = GameCommandMap::getCommandListFromMessage($messageGetEvent->getTextToWrite());
            $messageToWrite->isCommandForGame = true;

            $messageWriteEvent = new MessageWriteEvent($messageToWrite, $connection);
            $this->dispatcher->dispatch('message.write', $messageWriteEvent);

            if ($messageParsed->author === $connection->getBotStatus()->nick) {
                // need to sleep 1 second or the message will be banned
                sleep(1);
            }
            $write->ircPrivmsg($this->channel, $messageGetEvent->getTextToWrite());
        };
    }
}
