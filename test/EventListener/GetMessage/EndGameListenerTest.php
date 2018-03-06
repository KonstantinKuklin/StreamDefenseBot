<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class EndGameListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'ttdbot: map vote' => [
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
                    'prepare message' => [
                        'input_message' => ['bot1', '!t !archer'],
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                    'check' => [
                        'input_message' => ['ttdbot', 'Some map now in the lead!'],
                        'bot_stats_before' => ['class' => 'Archer', 'location' => 'Train'],
                        'bot_stats_after' => ['class' => null, 'location' => 'Map vote'],
                    ],
                ],
            ],
            'somebody: map vote' => [
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
                    'prepare message' => [
                        'input_message' => ['bot1', '!t !archer'],
                        'bot_stats_before' => [],
                        'bot_stats_after' => [],
                    ],
                    'check' => [
                        'input_message' => ['somebody', 'Some map now in the lead!'],
                        'bot_stats_before' => ['class' => 'Archer', 'location' => 'Train'],
                        'bot_stats_after' => ['class' => 'Archer', 'location' => 'Train'],
                    ],
                ],
            ],
        ];
    }
}
