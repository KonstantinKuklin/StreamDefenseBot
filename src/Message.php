<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot;


class Message
{
    public $author;

    public $gameCommandList = [];

    public $gameCommandTar;

    public $botCommandList = [];

    public $commandForNick;

    public $commandForGroup = [];

    public $isCommandForGame = false;
    public $hasIgnoreAttribute = false;

    public $text = '';
}
