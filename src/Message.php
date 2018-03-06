<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot;


class Message
{
    /** @deprecated  Use author */
    public $nick;

    public $author;

    public $gameCommandList = [];

    public $botCommandList = [];

    public $commandForNick;

    public $commandForGroup;

    public $isCommandForGame = false;

    /** @deprecated use text */
    public $message = '';

    public $text = '';
}
