<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Test\EventListener\GetMessage;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Test\EventListener\AbstractGetMessageEvents;

class StatsListenerTest extends AbstractGetMessageEvents
{
    public function dataGetMessage()
    {
        return [
            'ttdbot: send stats' => [
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
                        'input_message' => ['ttdbot', 'Lvl 34 sniper | Dmg: 4,141 (Buffed: 6,211 | CritChance: 15.20 %(Powered OR Low Health: 55.20 %) (Powered AND Low Health: 95.20 %) | CritDamage: 390.80 % | Range: 21.55m (Buffed: 32.32) | Atck Period: 4.00s (Buffed: 2.00) | Gold Earned this game: 89'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [
                            'lvl' => '34',
                            'class' => 'sniper',
                            'damage' => '4,141',
                            'criticalDamage' => '390.80',
                            'criticalChance' => '15.20',
                            'attackRange' => '21.55',
                            'attackPeriod' => '4.00',
                            'goldEarnedInThisGame' => '89',
                        ],
                    ],
                    [
                        'input_message' => ['ttdbot', 'Lvl 28 sniper | Dmg: 1,568 | CritChance: 15.20 %(Powered OR Low Health: 55.20 %) (Powered AND Low Health: 95.20 %) | CritDamage: 390.80 % | Range: 18.57m (Buffed: 27.86) | Atck Period: 4.00s (Buffed: 2.00) | Gold Earned this game: 9'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [
                            'lvl' => '28',
                            'class' => 'sniper',
                            'damage' => '1,568',
                            'criticalDamage' => '390.80',
                            'criticalChance' => '15.20',
                            'attackRange' => '18.57',
                            'attackPeriod' => '4.00',
                            'goldEarnedInThisGame' => '9',
                        ],
                    ],
                    [
                        'input_message' => ['ttdbot', 'Lvl 27 scout | Dmg: 720 | Range: 11.12m | Atck Period: 1.57s | Bonus XP Granted per Kill: ~2.47 | Gold Earned this game: 14'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [
                            'lvl' => '27',
                            'class' => 'scout',
                            'damage' => '720',
                            'attackRange' => '11.12',
                            'attackPeriod' => '1.57',
                            'bonusXpGranted' => '2.47',
                            'goldEarnedInThisGame' => '14',
                        ],
                    ],
                    [
                        'input_message' => ['ttdbot', 'Lvl 30 icemage | Dmg: 446 (Buffed: 669) | Range: 11.48m | Atck Period: 0.75s | Slowed Move Speed: 0.60 | Powered Freeze Chance: 3.75 % | Gold Earned this game: 486'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [
                            'lvl' => '30',
                            'class' => 'icemage',
                            'damage' => '446',
                            'attackRange' => '11.48',
                            'attackPeriod' => '0.75',
                            'slowedMoveSpeed' => '0.60',
                            'poweredFreezeChance' => '3.75',
                            'goldEarnedInThisGame' => '486',
                        ],
                    ],
                ],
            ],
            'somebody: send stats' => [
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
                        'input_message' => ['somebody', 'Lvl 34 sniper | Dmg: 4,141 (Buffed: 6,211 | CritChance: 15.20 %(Powered OR Low Health: 55.20 %) (Powered AND Low Health: 95.20 %) | CritDamage: 390.80 % | Range: 21.55m (Buffed: 32.32) | Atck Period: 4.00s (Buffed: 2.00) | Gold Earned this game: 89'],
                        'expected_message' => null,
                        'bot_stats_before' => [],
                        'bot_stats_after' => [
                            'criticalDamage' => null,
                        ],
                    ],
                ],
            ],
        ];
    }
}
