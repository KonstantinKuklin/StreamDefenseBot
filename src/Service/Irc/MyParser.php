<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service\Irc;


use Phergie\Irc\Parser;

class MyParser extends Parser
{
    public function __construct()
    {
        parent::__construct();
    }

    public function parse($message)
    {
        $parsed = parent::parse($message);
        if (!isset($parsed['invalid'])) {
            return $parsed;
        }

        // new PRIVMSG
        $parsedNew = $this->parseNewMsg($parsed['invalid']);
        if (!$parsedNew) {
            $parsedNew = $this->parseUserState($parsed['invalid']);
        }
        if (!$parsedNew) {
            $parsedNew = $this->parseClearChat($parsed['invalid']);
        }

        if (isset($parsed['tail']) && $parsedNew) {
            $parsedNew['tail'] = $parsed['tail'];
        }

        if ($parsedNew) {
            return $parsedNew;
        }

        // something was not parsed
        return null;
    }

    private function parseNewMsg($message)
    {
        $matches = [];
        \preg_match('/^(.)+user-type=[^:]*:(?P<sender>[^!]+)!([^ ]+) (?P<command>\w+) (?P<channel>[^ ]+) :(?P<text>.+)$/ui', $message, $matches);
        if ($matches) {
            $matches['message'] = \sprintf(':%s!:%s', \rtrim($matches['sender'], '!'), $matches['text']);
        }

        return $matches ?: null;
    }

    private function parseUserState($message)
    {
        $matches = [];
        \preg_match('/display-name=(?P<sender>[^;]+)(.+):tmi.twitch.tv (?P<command>[^ ]+) (?P<channel>[^ $]+)/ui', $message, $matches);
        if ($matches) {
            $matches['message'] = \sprintf(':%s!:', \rtrim($matches['sender'], '!'));
        }

        return $matches ?: null;
    }

    private function parseClearChat($message)
    {
        $matches = [];
        \preg_match('/CLEARCHAT (?P<channel>\#[^ $]+) :(?P<sender>[^;]+)/ui', $message, $matches);
        if ($matches) {
            $matches['command'] = 'CLEARCHAT';
            $matches['message'] = \sprintf(':%s!:', \rtrim($matches['sender'], '!'));
        }

        return $matches ?: null;
    }


}
