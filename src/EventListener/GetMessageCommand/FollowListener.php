<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessageCommand;


use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;

class FollowListener
{
    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage();
        if (!$command = $this->getCommand($message->text, $message->author)) {
            return;
        }

        list($what, $who, $forBotName) = $command;
        $botStatus = $event->getConnection()->getBotStatus();

        if ($forBotName && $botStatus->nick !== $forBotName) {
            // command was not for this bot
            return;
        }

        if ($what === 'follow') {
            if ($botStatus->followTo) {
                $event->setTextToWrite('Already follow @' . $botStatus->followTo);

                return;
            }
            $botStatus->followTo = $who;
            $event->setTextToWrite('Follow on @' . $who);
        } else {
            if ($message->author !== $botStatus->ownerNick && $botStatus->followTo !== $message->author) {
                return;
            }
            $botStatus->followTo = null;
            $event->setTextToWrite('@' . $who . ' unfollowed :(');
        }
    }

    private function getCommand($message, $connectionNick)
    {
        $mastches = [];
        $list = [
            // @botNick $follow @who
            '(?P<for1>^\@?[^ \n\r]+) (?P<follow1>\$follow) (?P<nick1>\@?[^ \n\r]+)',
            '(?P<for2>^\@?[^ \n\r]+) (?P<unfollow2>\$unfollow) (?P<nick2>\@?[^ \n\r]+)',

            // @botNick $follow
            '(?P<for3>^\@?[^ \n\r]+) (?P<follow3>\$follow)',
            '(?P<for4>^\@?[^ \n\r]+) (?P<unfollow4>\$unfollow)',

            // $follow @who
            '(?P<follow5>^\$follow) (?P<nick5>\@?[^ \n\r]+)',
            '(?P<unfollow6>^\$unfollow) (?P<nick6>\@?[^ \n\r]+)',

            // $follow
            '(?P<follow7>^\$follow)',
            '(?P<unfollow7>^\$unfollow)',
        ];
        $pattern = '/' . \implode('|', $list) . '/ui';
        preg_match($pattern, $message, $mastches);

        if ($this->getIfIsset($mastches, ['follow1', 'follow3', 'follow5', 'follow7'])) {
            return [
                'follow',
                \strtolower(trim($this->getIfIsset($mastches, ['nick1', 'nick5']) ?: $connectionNick, " \t\n\r\0\x0B@")),
                \strtolower(trim($this->getIfIsset($mastches, ['for1', 'for3']) ?: $connectionNick, " \t\n\r\0\x0B@")),
            ];
        }

        if ($this->getIfIsset($mastches, ['unfollow2', 'unfollow4', 'unfollow6'])) {
            return [
                'unfollow',
                \strtolower(trim($this->getIfIsset($mastches, ['nick2', 'nick6']) ?: $connectionNick, " \t\n\r\0\x0B@")),
                \strtolower(trim($this->getIfIsset($mastches, ['for2', 'for4']) ?: $connectionNick, " \t\n\r\0\x0B@")),
            ];
        }

        return null;
    }

    private function getIfIsset(array $data, array $keys)
    {
        foreach ($keys as $key) {
            if (isset($data[$key]) && $data[$key]) {
                return $data[$key];
            }
        }

        return null;
    }
}
