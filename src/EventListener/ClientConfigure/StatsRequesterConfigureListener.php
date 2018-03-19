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
use Phergie\Irc\Client\React\WriteStream;
use Psr\Log\LoggerInterface;

class StatsRequesterConfigureListener
{
    use ScreenRenderInjectTrait;
    const REQUEST_INTERVAL = 60;

    /**
     * @param ClientConfigureEvent $clientConfigureEvent
     *
     * @throws \InvalidArgumentException
     */
    public function handle(ClientConfigureEvent $clientConfigureEvent)
    {
        $client = $clientConfigureEvent->getClient();
        $channel = $clientConfigureEvent->getApplication()->getGameConfig()->getChannel();

        $callback = function (WriteStream $write, ConnectionConfig $connection, LoggerInterface $logger) use($channel) {

            $lastStatsRequestAt = (int)$connection->getBotStatus()->lastStatsRequestAt;
            if (time() < self::REQUEST_INTERVAL + $lastStatsRequestAt) {
                return;
            }

            if (!$connection->getBotStatus()->isInGame) {
                // not in game
                return;
            }

            $write->ircPrivmsg($channel, '/w ttdbot !stats');
            $connection->getBotStatus()->lastStatsRequestAt = time();

            $this->screenRender->addLogRecord(new LogRecord(
                $connection->getBotStatus()->nick,
                new Message(),
                'time to stats',
                'request stats'
            ));
        };

        $client->on('irc.tick', $callback);
    }
}
