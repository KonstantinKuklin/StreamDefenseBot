<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service;


class PrivillegeMap
{
    // who bot starts
    const PRIVILEGE_BOT_OWNER = 'bot_owner';
    // who does the bot go for
    const PRIVILEGE_LEADER = 'leader';
    const PRIVILEGE_ANYBODY = 'anybody';
    const MINIMAL_MAP = [
        self::PRIVILEGE_BOT_OWNER => [
            GameCommandMap::LEAVE,
            GameCommandMap::PING,
        ],
        self::PRIVILEGE_LEADER => [
            GameCommandMap::ALCHEMIST,
            GameCommandMap::ROGUE,
            GameCommandMap::BARD,
            GameCommandMap::FROSTMAGE,
            GameCommandMap::FIREMAGE,
            GameCommandMap::ARCHER,

            GameCommandMap::FILL,

            GameCommandMap::ALTAR,
            GameCommandMap::ALTAR_SHORT,
            GameCommandMap::POWER_DOWN,
            GameCommandMap::POWER_UP,
            GameCommandMap::TRAIN,
            GameCommandMap::TRAIN_SHORT,

            GameCommandMap::TOWER1,
            GameCommandMap::TOWER2,
            GameCommandMap::TOWER3,
            GameCommandMap::TOWER4,
            GameCommandMap::TOWER5,
            GameCommandMap::TOWER6,
            GameCommandMap::TOWER7,
            GameCommandMap::TOWER8,
            GameCommandMap::TOWER9,
            GameCommandMap::TOWER10,
            GameCommandMap::TOWER11,
            GameCommandMap::TOWER12,
        ],

        self::PRIVILEGE_ANYBODY => [

        ],
    ];

    public static function getAllowedCommands($role)
    {

    }
}
