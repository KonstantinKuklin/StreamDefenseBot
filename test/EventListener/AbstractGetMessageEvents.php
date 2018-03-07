<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener;

use KonstantinKuklin\StreamDefenseBot\ApplicationParts\ConnectionTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\DispatcherTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\TickPingerTrait;
use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\MessageParser;
use KonstantinKuklin\StreamDefenseBot\Service\BotStatus;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRender;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;

abstract class AbstractGetMessageEvents extends TestCase
{
    use DispatcherTrait;
    use ConnectionTrait;
    use TickPingerTrait;
    const MESSAGE_COMPARE_REGEXP = 1;

    abstract public function dataGetMessage();

    /**
     * @dataProvider dataGetMessage
     */
    public function testGetMessage($connectionConfig, $messageBehaviorCheckList)
    {
        $this->initConnectionList([$connectionConfig]);
        $botNames = array_map(function ($botConfig) {
            return $botConfig['login'];
        }, [$connectionConfig]);
        $this->initTickPinger($botNames, 0);
        $this->initEventListener();
        $connectionConfigInstance = \array_pop($this->connectionList);

        foreach ($messageBehaviorCheckList as $messageBehaviorCheck) {
            list($nick, $message) = $messageBehaviorCheck['input_message'];
            $message = \sprintf(':%s!:%s', $nick, $message);

            $messageParsed = MessageParser::getParsedMessage($message);
            $this->botStatusCheck(
                $connectionConfigInstance->getBotStatus(),
                $messageBehaviorCheck['bot_stats_before'],
                'before',
                $message
            );

            $getMessageEvent = new MessageEvent($messageParsed, $connectionConfigInstance);
            $this->dispatcher->dispatch('message.get', $getMessageEvent);

            $this->botStatusCheck(
                $connectionConfigInstance->getBotStatus(),
                $messageBehaviorCheck['bot_stats_after'],
                'after',
                $message
            );

            $textToWrite = $getMessageEvent->getTextToWrite();

            if (\array_key_exists('expected_message', $messageBehaviorCheck)) {
                if (!\is_array($messageBehaviorCheck['expected_message'])) {
                    self::assertEquals(
                        $messageBehaviorCheck['expected_message'],
                        $textToWrite,
                        "Message:[{$message}]. Unexpected text to write."
                    );
                }
                list($howToCompare, $value) = $messageBehaviorCheck['expected_message'];
                switch ($howToCompare) {
                    case self::MESSAGE_COMPARE_REGEXP:
                        self::assertRegExp($value, $textToWrite, "Message:[{$message}]");
                        break;
                }
            }
        }
    }

    private function botStatusCheck(BotStatus $botStatus, $data, $when, $messageText)
    {
        foreach ($data as $key => $value) {
            self::assertEquals($value, $botStatus->$key, "Message:[{$messageText}]. {$when}: Incorrect value in BotStatus[{$key}]");
        }
    }

    public function getScreenRender() : ScreenRender
    {
        return new ScreenRender(new NullOutput());
    }
}
