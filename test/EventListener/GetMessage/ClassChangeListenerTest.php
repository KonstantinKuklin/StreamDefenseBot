<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class ClassChangeListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'self: change class' => [
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
                        'input_message' => ['bot1', GameCommandMap::ROGUE],
                        'bot_stats_before' => ['class' => null],
                        'bot_stats_after' => ['class' => 'Rogue'],
                    ],
                ],
            ],
            'somebody: change class' => [
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
                        'input_message' => ['somebody', GameCommandMap::ROGUE],
                        'bot_stats_before' => ['class' => null],
                        'bot_stats_after' => ['class' => null],
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
                        'bot_stats_before' => ['class' => null],
                        'bot_stats_after' => ['class' => null],
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
                        'bot_stats_before' => ['class' => null],
                        'bot_stats_after' => ['class' => null],
                    ],
                ],
            ],
        ];
    }
}
