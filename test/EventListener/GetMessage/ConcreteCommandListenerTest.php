<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class ConcreteCommandListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'self: to self' => [
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
                        'input_message' => ['bot1', '@bot1 !p'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: power up to bot' => [
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
                        'input_message' => ['owner', '@bot1 !p'],
                        'expected_message' => '!p',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: leave to bot' => [
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
                        'input_message' => ['owner', '@bot1 !leave'],
                        'expected_message' => '!leave',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: change class to bot' => [
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
                        'input_message' => ['owner', '@bot1 !rogue'],
                        'expected_message' => '!rogue',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'owner: move to group' => [
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
                        'input_message' => ['owner', 'test!t'],
                        'expected_message' => '!t',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: move to bot' => [
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
                        'input_message' => ['leader', '@bot1 !p'],
                        'expected_message' => '!p',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: change target priority' => [
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
                        'input_message' => ['leader', '@bot1 !tarp+b'],
                        'expected_message' => '!tarp+b',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                    [
                        'input_message' => ['leader', '@bot1 !tarp=b,s'],
                        'expected_message' => '!tarp=b,s',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                    [
                        'input_message' => ['leader', '@bot1 !tar=b,s'],
                        'expected_message' => '!tar=b,s',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: leave to bot' => [
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
                        'input_message' => ['leader', '@bot1 !leave'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: change class to bot' => [
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
                        'input_message' => ['leader', '@bot1 !rogue'],
                        'expected_message' => '!rogue',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: move to group' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'd',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                ],
                'messages to check' => [
                    [
                        'input_message' => ['leader', 'd!t'],
                        'expected_message' => '!t',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: change class and move for bot' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'd',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                ],
                'messages to check' => [
                    [
                        'input_message' => ['leader', '!archer !2 d!bard d!3'],
                        'expected_message' => '!bard !3',
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: hire merc' => [
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
                        'input_message' => ['leader', '@bot1 ' . GameCommandMap::HIRE_ADARA],
                        'expected_message' => GameCommandMap::HIRE_ADARA,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'leader: merc move' => [
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
                        'input_message' => ['leader', '@bot1 ' . GameCommandMap::MERC_TOWER1],
                        'expected_message' => GameCommandMap::MERC_TOWER1,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
        ];
    }
}
