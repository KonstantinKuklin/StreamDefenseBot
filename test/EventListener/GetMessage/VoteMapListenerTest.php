<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class VoteMapListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'ttdbot: map vote denied' => [
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
                        'input_message' => ['ttdbot', 'now in the lead!'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'ttdbot: map vote allowed' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                    'map_vote' => true,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['ttdbot', 'now in the lead!'],
                        'expected_message' => [AbstractGetMessageEvents::MESSAGE_COMPARE_REGEXP, '/!map\d/ui'],
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
            'somebody: map vote allowed' => [
                'connectionData' => [
                    'login' => 'bot1',
                    'class' => GameCommandMap::ARCHER,
                    'owner_nick' => 'owner',
                    'group' => 'test',
                    'auto_start' => false,
                    'password' => '',
                    'follow_to' => 'leader',
                    'map_vote' => true,
                ],
                'messages to check' => [
                    [
                        'input_message' => ['somebody', 'now in the lead!'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                ],
            ],
        ];
    }
}
