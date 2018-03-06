<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessageCommand;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class FollowListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'owner: $follow' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => null,
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['owner', '$follow'],
                        'bot_stats_before' => ['followTo' => null],
                        'bot_stats_after' => ['followTo' => null],
                    ],
                ],
            ],
            'owner: follow|unfollow to bot' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => null,
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['owner', '@bot1 $follow'],
                        'bot_stats_before' => ['followTo' => null],
                        'bot_stats_after' => ['followTo' => 'owner'],
                    ],
                    [
                        'input_message' => ['owner', '@bot1 $unfollow'],
                        'bot_stats_before' => ['followTo' => 'owner'],
                        'bot_stats_after' => ['followTo' => null],
                    ],
                ],
            ],
            'owner: follow to unknown bot' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => null,
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['owner', '@bot2 $follow'],
                        'bot_stats_before' => ['followTo' => null],
                        'bot_stats_after' => ['followTo' => null],
                    ],
                ],
            ],
            'owner: follow to bot to follow somebody' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => null,
                    'map_vote' => false,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['owner', '@bot1 $follow @somebody'],
                        'bot_stats_before' => ['followTo' => null],
                        'bot_stats_after' => ['followTo' => 'somebody'],
                    ],
                    [
                        'input_message' => ['owner', '@bot1 $unfollow'],
                        'bot_stats_before' => ['followTo' => 'somebody'],
                        'bot_stats_after' => ['followTo' => null],
                    ],
                    [
                        'input_message' => ['owner', '@bot1 $follow @somebody'],
                        'bot_stats_before' => ['followTo' => null],
                        'bot_stats_after' => ['followTo' => 'somebody'],
                    ],
                    [
                        'input_message' => ['somebody', '@bot1 $unfollow'],
                        'bot_stats_before' => ['followTo' => 'somebody'],
                        'bot_stats_after' => ['followTo' => null],
                    ],
                ],
            ],
        ];
    }
}
