<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure;


use KonstantinKuklin\StreamDefenseBot\Event\ClientConfigureEvent;
use KonstantinKuklin\StreamDefenseBot\TickPinger;
use Phergie\Irc\Client\React\WriteStream;
use Phergie\Irc\ConnectionInterface;
use Psr\Log\LoggerInterface;

class ScreenRenderConfigureListener
{
    /**
     * @param ClientConfigureEvent $clientConfigureEvent
     *
     * @throws \InvalidArgumentException
     */
    public function handle(ClientConfigureEvent $clientConfigureEvent)
    {
        $client = $clientConfigureEvent->getClient();
        $screenRender = $clientConfigureEvent->getApplication()->getScreenRender();
        $connectionList = $clientConfigureEvent->getApplication()->getConnectionList();

        $callback = function () use ($screenRender, $connectionList) {
            $screenRender->render($connectionList);
        };

        $client->addPeriodicTimer(2, $callback);
    }
}
