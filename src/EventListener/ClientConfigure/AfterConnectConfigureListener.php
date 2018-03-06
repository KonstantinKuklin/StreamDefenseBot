<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure;

use KonstantinKuklin\StreamDefenseBot\Config\ConnectionConfig;
use KonstantinKuklin\StreamDefenseBot\Event\ClientConfigureEvent;
use KonstantinKuklin\StreamDefenseBot\Service\Irc\MyWriteStream;
use Phergie\Irc\Client\React\WriteStream;
use Phergie\Irc\ConnectionInterface;

class AfterConnectConfigureListener
{
    /**
     * @param ClientConfigureEvent $clientConfigureEvent
     *
     * @throws \InvalidArgumentException
     */
    public function handle(ClientConfigureEvent $clientConfigureEvent)
    {
        $client = $clientConfigureEvent->getClient();
        $channel = $clientConfigureEvent->getApplication()->getGameConfig()->getChannel();
        $logger = $clientConfigureEvent->getApplication()->getLogger();

        $callback = function (ConnectionConfig $connection, MyWriteStream $write) use ($channel, $logger) {
            $write->ircJoin($channel);
            $connection->getBotStatus()->startedAt = time();

            // special mods to hear WHISPER messages
            $write->ircCapReq('twitch.tv/commands');
            $write->ircCapReq('twitch.tv/membership');
            $write->ircCapReq('twitch.tv/tags');
        };

        $client->on('connect.after.each', $callback);
    }
}
