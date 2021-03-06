<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Message;
use KonstantinKuklin\StreamDefenseBot\Service\BotStatus;
use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class StatsListener
{
    use ScreenRenderInjectTrait;

    /**
     * @param MessageEvent $event
     *
     * @throws \ReflectionException
     */
    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage()->text;
        $messageAuthor = $event->getMessage()->author;

        if ($messageAuthor !== 'ttdbot') {
            return;
        }

        $botStatus = $event->getConnection()->getBotStatus();
        $stats = $this->parseStatsMessage($message);
        if (!$stats) {
            if ($this->parseNotInGame($message)) {
                $botStatus->isInGame = false;
            }

            return;
        }

        $botStatus->isInGame = true;
        foreach (BotStatus::GAME_STATS as $stat) {
            if (isset($stats[$stat])) {
                $botStatus->$stat = $stats[$stat];
                continue;
            }
            $botStatus->$stat = null;
        }

        $this->screenRender->addLogRecord(new LogRecord(
            $event->getConnection()->getBotStatus()->nick,
            new Message(),
            'got stats',
            'update stats'
        ));
    }

    private function parseStatsMessage($message)
    {
        $patternList = [
            'Lvl (?P<lvl>\d+) (?P<class>\w+)',
            'Dmg: (?P<damage>[\d\,]+)',
            'Range: (?P<attackRange>[\d\.]+)m?',
            'Atck Period: (?P<attackPeriod>[\d\.]+)s?',
            'Bonus XP Granted per Kill: ~?(?P<bonusXpGranted>[\d\.]+)',
            'Gold Earned this game: (?P<goldEarnedInThisGame>\d+)',
            'CritChance: (?P<criticalChance>[\d\.]+)',
            'CritDamage: (?P<criticalDamage>[\d\.]+)',
            'Slowed Move Speed: (?P<slowedMoveSpeed>[\d\.]+)',
            'Powered Freeze Chance: (?P<poweredFreezeChance>[\d\.]+)',
        ];
        $matches = [];
        $pattern = \sprintf('/%s/ui', implode('|', $patternList));
        \preg_match_all($pattern, $message, $matches);

        $return = [];
        foreach ($matches as $key => $matchList) {
            if (\is_numeric($key)) {
                continue;
            }
            foreach ($matchList as $value) {
                if ($value) {
                    $return[$key] = $value;
                    break;
                }
            }
        }

        return $return;
    }

    private function parseNotInGame($message)
    {
        $matches = [];
        \preg_match('/You must join the game/ui', $message, $matches);

        return count($matches) !== 0;
    }
}
