<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\ApplicationParts;

use KonstantinKuklin\StreamDefenseBot\Config\ConnectionConfig;
use KonstantinKuklin\StreamDefenseBot\Service\BotStatus;
use Phergie\Irc\Connection;

trait ConnectionTrait
{
    /**
     * @var ConnectionConfig[]
     */
    private $connectionList;

    protected function initConnectionList($botsConfig)
    {
        foreach ($botsConfig as $bot) {
            $botMain = [
                'serverHostname' => 'irc.twitch.tv',
                'username' => $bot['login'],
                'realname' => $bot['login'],
                'nickname' => $bot['login'],
                'password' => $bot['password'],
                'port' => 6667,
            ];

            $botStatus = new BotStatus();
            $botStatus->nick = \strtolower(trim($bot['login']));
            $botStatus->ownerNick = \strtolower(trim($bot['owner_nick']));
            $botStatus->classInited = $bot['class'];
            $botStatus->group = $bot['group'] ?? null;
            $botStatus->autoStartInGame = $bot['auto_start'] ?? false;
            $botStatus->followTo = $bot['follow_to'] ?? null;
            $botStatus->isMapVoteAllowed = $bot['map_vote'] ?? false;
            $botStatus->preferWhisper = $bot['prefer_whisper'] ?? false;

            $botMain['options'] = $bot;
            $botMain['options']['status'] = $botStatus;
            $this->connectionList[] = new ConnectionConfig($botMain);
        }
    }

    /**
     * @return ConnectionConfig[]
     */
    public function getConnectionList()
    {
        return $this->connectionList;
    }
}
