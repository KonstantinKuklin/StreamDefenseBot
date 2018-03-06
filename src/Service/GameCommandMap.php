<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service;


use ReflectionClass;

class GameCommandMap
{
    const GOLD = '!gold';
    const PING = '!';
    const SUPER_POWER = '!sp';
    const POWER_UP = '!p';
    const POWER_DOWN = '!pd';
    const TRAIN = '!train';
    const TRAIN_SHORT = '!t';
    const FILL = '!fill';
    const ALTAR = '!altar';
    const ALTAR_SHORT = '!a';
    const ARCHER = '!archer';
    const ROGUE = '!rogue';
    const FIREMAGE = '!firemage';
    const FROSTMAGE = '!frostmage';
    const ALCHEMIST = '!alchemist';
    const BARD = '!bard';
    const LEAVE = '!leave';

    const HIRE_SHADE = '!hireshade';
    const HIRE_ICELO = '!hireicelo';
    const HIRE_ADARA = '!hireadara';
    const HIRE_MOOR = '!hiremoor';
    const HIRE_MOLAN = '!hiremolan';
    const HIRE_GUNNAR = '!hiregunnar';
    const HIRE_JUBAL = '!hirejubal';
    const HIRE_CORTEZ = '!hirecortez';

    const MERC_FOLLOW = '!mfollow';
    const MERC_UNFOLLOW = '!mfollow';

    const MERC_TRAIN_SHORT = '!mt';
    const MERC_TRAIN = '!mtrain';
    const MERC_SUPER_POWER = '!msp';
    const MERC_POWER_UP = '!mp';
    const MERC_POWER_DOWN = '!mpd';
    const MERC_ALTAR_SHORT = '!ma';
    const MERC_ALTAR = '!ma';
    const MERC_FILL = '!mfill';
    const MERC_TOWER1 = '!m1';
    const MERC_TOWER2 = '!m2';
    const MERC_TOWER3 = '!m3';
    const MERC_TOWER4 = '!m4';
    const MERC_TOWER5 = '!m5';
    const MERC_TOWER6 = '!m6';
    const MERC_TOWER7 = '!m7';
    const MERC_TOWER8 = '!m8';
    const MERC_TOWER9 = '!m8';
    const MERC_TOWER10 = '!m10';
    const MERC_TOWER11 = '!m11';
    const MERC_TOWER12 = '!m12';

    const TOWER1 = '!1';
    const TOWER2 = '!2';
    const TOWER3 = '!3';
    const TOWER4 = '!4';
    const TOWER5 = '!5';
    const TOWER6 = '!6';
    const TOWER7 = '!7';
    const TOWER8 = '!8';
    const TOWER9 = '!9';
    const TOWER10 = '!10';
    const TOWER11 = '!11';
    const TOWER12 = '!12';
    const MAP1 = '!map1';
    const MAP2 = '!map2';
    const MAP3 = '!map3';
    const MAP4 = '!map4';
    const MAP5 = '!map5';
    const MAP6 = '!map6';
    const MAP7 = '!map7';
    const MAP8 = '!map8';
    const MAP9 = '!map9';
    const CLASS_MAP = [
        self::ARCHER,
        self::ROGUE,
        self::FROSTMAGE,
        self::FIREMAGE,
        self::BARD,
        self::ALCHEMIST,
    ];
    const CHANGE_LOCATION_MAP = [
        self::TRAIN_SHORT,
        self::TRAIN,
        self::ALTAR,
        self::ALTAR_SHORT,
        self::FILL,
        self::TOWER1,
        self::TOWER2,
        self::TOWER3,
        self::TOWER4,
        self::TOWER5,
        self::TOWER6,
        self::TOWER7,
        self::TOWER8,
        self::TOWER9,
        self::TOWER10,
        self::TOWER11,
        self::TOWER12,
    ];

    const ALLOWED_TO_REPEAT_MAP = [
        self::TRAIN,
        self::TRAIN_SHORT,
        self::SUPER_POWER,
        self::ALTAR_SHORT,
        self::ALTAR,
        self::POWER_DOWN,
        self::POWER_UP,
        self::TOWER1,
        self::TOWER2,
        self::TOWER3,
        self::TOWER4,
        self::TOWER5,
        self::TOWER6,
        self::TOWER7,
        self::TOWER8,
        self::TOWER9,
        self::TOWER10,
        self::TOWER11,
        self::TOWER12,
        self::FILL,
        self::PING,
        self::LEAVE,
    ];

    const CAN_BE_WHISPERED = [
        self::ARCHER,
        self::BARD,
        self::ROGUE,
        self::ALCHEMIST,
        self::FIREMAGE,
        self::FROSTMAGE,
        self::ALTAR,
        self::ALTAR_SHORT,
        self::TRAIN,
        self::TRAIN_SHORT,
        self::TOWER1,
        self::TOWER2,
        self::TOWER3,
        self::TOWER4,
        self::TOWER5,
        self::TOWER6,
        self::TOWER7,
        self::TOWER8,
        self::TOWER9,
        self::TOWER10,
        self::TOWER11,
        self::TOWER12,
        self::FILL,
        self::SUPER_POWER,
        self::POWER_UP,
        self::POWER_DOWN,
        self::PING,
    ];

    private static $allVariants;

    /**
     * @param string $message
     *
     * @throws \ReflectionException
     * @return string[]
     * @throws \Exception
     */
    public static function getCommandListFromMessage(string $message)
    {
        $wordList = \explode(' ', trim($message));
        if (!$wordList) {
            throw new \Exception('Invalid message:' . $message);
        }

        return \array_values(\array_intersect($wordList, self::getAllCommandList()));
    }

    /**
     * @throws \ReflectionException
     */
    public static function getAllCommandList()
    {
        if (!self::$allVariants) {
            $reflection = new ReflectionClass(__CLASS__);
            $constantList = $reflection->getConstants();
            foreach ($constantList as $constant) {
                if (\is_string($constant)) {
                    self::$allVariants[] = $constant;
                }
            }
        }

        return self::$allVariants;
    }

    /**
     * @param string $message
     *
     * @return string
     * @throws \ReflectionException
     * @throws \Exception
     */
    public static function getTextCommandFromMessage(string $message)
    {
        $allowedCommandList = self::getCommandListFromMessage($message);

        return implode(' ', $allowedCommandList);
    }
}
