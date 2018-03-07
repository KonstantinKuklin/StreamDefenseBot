<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure;


use KonstantinKuklin\StreamDefenseBot\Config\ConnectionConfig;
use KonstantinKuklin\StreamDefenseBot\Event\ClientConfigureEvent;
use KonstantinKuklin\StreamDefenseBot\Message;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;
use KonstantinKuklin\StreamDefenseBot\TickPinger;
use Phergie\Irc\Client\React\WriteStream;
use Psr\Log\LoggerInterface;

class TickConfigureListener
{
    use ScreenRenderInjectTrait;

    /**
     * @param ClientConfigureEvent $clientConfigureEvent
     *
     * @throws \InvalidArgumentException
     */
    public function handle(ClientConfigureEvent $clientConfigureEvent)
    {
        $client = $clientConfigureEvent->getClient();
        $tickPinger = $clientConfigureEvent->getApplication()->getTickPinger();
        $channel = $clientConfigureEvent->getApplication()->getGameConfig()->getChannel();
        $client->setTickInterval(30);

        $callback = function (WriteStream $write, ConnectionConfig $connection, LoggerInterface $logger) use ($tickPinger, $channel) {
            $timeOuted = $tickPinger->isTimeOuted($connection->getNickname());
            $class = $connection->getBotStatus()->class;
            if ($class && $timeOuted) {
                $write->ircPrivmsg($channel, '!');
                $tickPinger->update($connection->getNickname());

                $this->screenRender->addLogRecord(new LogRecord(
                    $connection->getBotStatus()->nick,
                    new Message(),
                    'AKF timer',
                    'send !'
                ));
            }
        };

        $client->on('irc.tick', $callback);
    }
}
