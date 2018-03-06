<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Event;


use KonstantinKuklin\StreamDefenseBot\Application;
use Phergie\Irc\Client\React\Client;
use Symfony\Component\EventDispatcher\Event;

class ClientConfigureEvent extends Event
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Application
     */
    private $application;

    public function __construct(Client $client, Application $application)
    {
        $this->client = $client;
        $this->application = $application;
    }

    /**
     * @return Client
     */
    public function getClient() : Client
    {
        return $this->client;
    }

    /**
     * @return Application
     */
    public function getApplication() : Application
    {
        return $this->application;
    }
}
