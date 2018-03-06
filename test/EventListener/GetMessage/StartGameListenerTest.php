<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class StartGameListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'ttdbot: start game. bot auto start denied' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                ],
                'messages to check' => [
                    [
                        'input_message' => ['ttdbot', 'WAVE 1 SENT. Next:'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'ttdbot: start game. bot with auto start' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => true,
                    'password' => '',
                    'follow_to' => 'leader',
                ],
                'messages to check' => [
                    [
                        'input_message' => ['ttdbot', 'WAVE 1 SENT. Next:'],
                        'expected_message' => GameCommandMap::ARCHER,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'somebody: start game. bot with auto start' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => true,
                    'password' => '',
                    'follow_to' => 'leader',
                ],
                'messages to check' => [
                    [
                        'input_message' => ['somebody', 'WAVE 1 SENT. Next:'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
        ];
    }
}
