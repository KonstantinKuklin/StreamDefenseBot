<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class RepeatCommandListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'bot: move to tower' => [
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
                        'input_message' => ['bot1', GameCommandMap::TOWER1],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'somebody: move to tower' => [
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
                        'input_message' => ['somebody', GameCommandMap::TOWER1],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: move to tower' => [
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
                        'input_message' => ['owner', GameCommandMap::TOWER1],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: move to train' => [
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
                        'input_message' => ['owner', GameCommandMap::TRAIN],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: move to altar' => [
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
                        'input_message' => ['owner', GameCommandMap::ALTAR],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: change class' => [
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
                        'input_message' => ['owner', GameCommandMap::ROGUE],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner-leader: leave' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'owner',
                ],
                'messages to check' => [
                    [
                        'input_message' => ['owner', GameCommandMap::LEAVE],
                        'expected_message' => GameCommandMap::LEAVE,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: move to tower' => [
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
                        'input_message' => ['leader', GameCommandMap::TOWER1],
                        'expected_message' => GameCommandMap::TOWER1,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: move to train' => [
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
                        'input_message' => ['leader', GameCommandMap::TRAIN],
                        'expected_message' => GameCommandMap::TRAIN,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: move to altar' => [
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
                        'input_message' => ['leader', GameCommandMap::ALTAR],
                        'expected_message' => GameCommandMap::ALTAR,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: leave' => [
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
                        'input_message' => ['leader', GameCommandMap::LEAVE],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: change class' => [
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
                        'input_message' => ['leader', GameCommandMap::ROGUE],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
        ];
    }
}
