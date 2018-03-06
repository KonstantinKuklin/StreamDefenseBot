<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class ChangeLocationListenerTest extends AbstractGetMessageEvents
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
                        'bot_stats_before' => ['location' => 'unknown'],
                        'bot_stats_after' => ['location' => 'Tower 1'],
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
                        'bot_stats_before' => ['location' => 'unknown'],
                        'bot_stats_after' => ['location' => 'unknown'],
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
                        'bot_stats_before' => ['location' => 'unknown'],
                        'bot_stats_after' => ['location' => 'unknown'],
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
                        'bot_stats_before' => ['location' => 'unknown'],
                        'bot_stats_after' => ['location' => 'unknown'],
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
                        'bot_stats_before' => ['location' => 'unknown'],
                        'bot_stats_after' => ['location' => 'unknown'],
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
                        'bot_stats_before' => ['location' => 'unknown'],
                        'bot_stats_after' => ['location' => 'unknown'],
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
                        'bot_stats_before' => ['location' => 'unknown'],
                        'bot_stats_after' => ['location' => 'unknown'],
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
                        'bot_stats_before' => ['location' => 'unknown'],
                        'bot_stats_after' => ['location' => 'unknown'],
                    ],
                ],
            ],
        ];
    }
}
