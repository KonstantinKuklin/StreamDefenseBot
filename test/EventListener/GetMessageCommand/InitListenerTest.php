<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessageCommand;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class InitListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'owner: init twice' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['owner', '$init'],
                        'expected_message' => GameCommandMap::ARCHER,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                    [
                        'input_message' => ['owner', '$init'],
                        'expected_message' => GameCommandMap::ARCHER,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: init concrete' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['owner', '@bot1 $init'],
                        'expected_message' => GameCommandMap::ARCHER,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                    [
                        'input_message' => ['owner', '@bot2 $init'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                    [
                        'input_message' => ['owner', 'test$init'],
                        'expected_message' => GameCommandMap::ARCHER,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                    [
                        'input_message' => ['owner', 'test2$init'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: init self' => [
                'connectionData' => [
                    'login' => 'owner',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['owner', '$init'],
                        'expected_message' => GameCommandMap::ARCHER,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: init' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['leader', '$init'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'somebody: init' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['somebody', '$init'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
        ];
    }
}
