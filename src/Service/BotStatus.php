<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service;

class BotStatus
{
    const GAME_STATS = [
        'lvl',
        'class',
        'damage',
        'criticalDamage',
        'criticalChance',
        'attackRange',
        'attackPeriod',
        'goldEarnedInThisGame',
        'bonusXpGranted',
        'slowedMoveSpeed',
        'poweredFreezeChance',
    ];

    public
        $nick,
        $ownerNick,
        $powerUp = false,
        $startedAt,
        $followTo,
        $classInited,
        $lastActivity,
        $lastStatsRequestAt,
        $location = 'unknown',
        $autoStartInGame = true,
        $group,
        $isMapVoteAllowed = false,
        $preferWhisper = false,
        $isInGame = false,
        $isMovementsAllowed = true,
        $isLeft = false,

        $lvl,
        $class,
        $damage,
        $criticalDamage,
        $criticalChance,
        $attackRange,
        $attackPeriod,
        $goldEarnedInThisGame,
        $bonusXpGranted,
        $slowedMoveSpeed,
        $poweredFreezeChance;
}
