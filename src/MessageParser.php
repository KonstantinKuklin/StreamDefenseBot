<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot;


use KonstantinKuklin\StreamDefenseBot\Service\GameCommandMap;

class MessageParser
{
    // Grammar like:
    // =============
    // = Ignore:
    // somebody: just_sometext

    // = Game commands:
    // owner|leader: !game_command
    // owner|leader: group!game_command
    // owner|leader: @for !game_command

    // = Bot commands:
    // owner|leader: $bot_command
    // owner|leader: group$bot_command
    // owner|leader: @for $bot_command

    /**
     * @param string $text
     *
     * @return Message
     */
    public static function getParsedMessage(string $text) : Message
    {
        $matches = [];
        \preg_match('/^:(?P<author>[^!]+)([^:]*):(?P<text>.+)$/ui', $text, $matches);

        $text = trim($matches['text']);
        $author = \strtolower(trim($matches['author']));

        $message = self::getBotCommand($text);
        if (!$message) {
            $message = self::getGameCommand($text);
        }
        if (!$message) {
            $message = new Message();
        }

        if ($text[0] === '!') {
            $message->isCommandForGame = true;
        }

        $message->nick = $message->author = $author;
        $message->message = $message->text = $text;


        return $message;
    }

    /**
     * @param string $text
     *
     * @return Message|null
     */
    private static function getBotCommand(string $text)
    {
        $matches = [];
        \preg_match('/^(?P<for_group>^[\w][^\$]+)(?P<command>\$[^ ]+)/ui', $text, $matches);
        $message = new Message();
        if ($matches) {
            $message->commandForGroup = $matches['for_group'];
            $message->botCommandList = [$matches['command']];

            return $message;
        }

        \preg_match('/^(?P<for_nick>\@[^\$]+) (?P<command>\$[^ ]+)/ui', $text, $matches);
        if ($matches) {
            $message->commandForNick = \strtolower(trim($matches['for_nick'], '@'));
            $message->botCommandList = [$matches['command']];

            return $message;
        }
        \preg_match('/^(?P<command>\$[^ ]+)/ui', $text, $matches);
        if ($matches) {
            $message->botCommandList = [$matches['command']];

            return $message;
        }

        return null;
    }

    /**
     * @param string $text
     *
     * @return Message|null
     */
    private static function getGameCommand(string $text)
    {
        $matches = [];
        \preg_match('/(?P<for_group>^[\w][^\$!]+)(?P<command>![\w !]+)/ui', $text, $matches);
        $message = new Message();
        try {
            if ($matches) {
                $message->commandForGroup = $matches['for_group'];
                $message->gameCommandList = GameCommandMap::getCommandListFromMessage($matches['command']);

                return $message;
            }

            $matches = [];
            \preg_match('/^(?P<for_nick>\@[^\$ ]+) (?P<command>![\w !]+)/ui', $text, $matches);
            if ($matches) {
                $message->commandForNick = \strtolower(trim($matches['for_nick'], '@'));
                $message->gameCommandList = GameCommandMap::getCommandListFromMessage($matches['command']);

                return $message;
            }

            $matches = [];
            \preg_match('/^(?P<command>![\w !]+)/ui', $text, $matches);
            if ($matches) {
                $message->gameCommandList = GameCommandMap::getCommandListFromMessage($matches['command']);

                return $message;
            }
        } catch (\Exception $e) {
            //
        }

        return null;
    }
}
