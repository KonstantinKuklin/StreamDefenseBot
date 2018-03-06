<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\ApplicationParts;

use KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure\ScreenRenderConfigureListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure\StatsRequesterConfigureListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure\TickConfigureListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure\ReceiverListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\ClientConfigure\AfterConnectConfigureListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\ChangeLocationListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\ClassChangeListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\EndGameListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\LastActivityListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\PowerChangeListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\RepeatCommandListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\ConcreteCommandListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\StartGameListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\StatsListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage\VoteMapListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessageCommand\FollowListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\GetMessageCommand\InitListener;
use KonstantinKuklin\StreamDefenseBot\EventListener\PrepareMessage\WrongCommandListener;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRender;
use KonstantinKuklin\StreamDefenseBot\TickPinger;
use Symfony\Component\EventDispatcher\EventDispatcher;

trait DispatcherTrait
{
    /** @var EventDispatcher */
    private $dispatcher;

    private function initMessageGet()
    {
        // should hear all messages
        $this->dispatcher->addListener('message.get', [new FollowListener(), 'handle']);
        $this->dispatcher->addListener('message.get', [new InitListener(), 'handle']);

        $this->dispatcher->addListener('message.get', [new ChangeLocationListener(), 'handle']);
        $this->dispatcher->addListener('message.get', [new ClassChangeListener(), 'handle']);
        $this->dispatcher->addListener('message.get', [new PowerChangeListener(), 'handle']);
        $this->dispatcher->addListener('message.get', [new StatsListener(), 'handle']);

        $this->dispatcher->addListener('message.get', [new LastActivityListener($this->getTickPinger()), 'handle']);
        $this->dispatcher->addListener('message.get', [new EndGameListener(), 'handle']);

        // hear only with access
        $this->dispatcher->addListener('message.get', [new VoteMapListener(), 'handle']);
        $this->dispatcher->addListener('message.get', [new StartGameListener(), 'handle']);
        $this->dispatcher->addListener('message.get', [new ConcreteCommandListener(), 'handle']);
        $this->dispatcher->addListener('message.get', [new RepeatCommandListener(), 'handle']);
    }

    private function initMessagePrepare()
    {
        $this->dispatcher->addListener('message.prepare', [new WrongCommandListener(), 'handle']);
    }

    private function initMessageWrite()
    {
        $this->dispatcher->addListener('message.write', [new LastActivityListener($this->getTickPinger()), 'handle']);
        $this->dispatcher->addListener('message.write', [new ChangeLocationListener(), 'handle']);
        $this->dispatcher->addListener('message.write', [new ClassChangeListener(), 'handle']);
        $this->dispatcher->addListener('message.write', [new PowerChangeListener(), 'handle']);
    }

    private function initClientConfigure()
    {
        $this->dispatcher->addListener('client.configure', [new TickConfigureListener(), 'handle']);
        $this->dispatcher->addListener('client.configure', [new ReceiverListener(), 'handle']);
        $this->dispatcher->addListener('client.configure', [new AfterConnectConfigureListener(), 'handle']);
        $this->dispatcher->addListener('client.configure', [new ScreenRenderConfigureListener(), 'handle']);
        $this->dispatcher->addListener('client.configure', [new StatsRequesterConfigureListener(), 'handle']);
    }

    protected function initEventListener()
    {
        $this->dispatcher = new EventDispatcher();
        $this->initMessageGet();
        $this->initMessagePrepare();
        $this->initClientConfigure();
        $this->initMessageWrite();

        $eventListenerList = $this->dispatcher->getListeners();
        foreach ($eventListenerList as $event => $eventListenerEventList) {
            foreach ($eventListenerEventList as list($eventListener, $function)) {
                if (\method_exists($eventListener, 'setScreenRender')) {
                    $eventListener->setScreenRender($this->getScreenRender());
                }
            }
        }
    }

    public function getEventDispatcher() : EventDispatcher
    {
        return $this->dispatcher;
    }
}
