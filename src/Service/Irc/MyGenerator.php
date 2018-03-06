<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service\Irc;


use Phergie\Irc\Generator;

class MyGenerator extends Generator
{
    /**
     * Returns a CAP REQ message.
     *
     * @param string $text
     * @return string
     */
    public function ircCapReq($text)
    {
        return $this->getIrcMessage('CAP REQ', array($text));
    }
}
