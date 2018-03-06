<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service\Irc;

use \Phergie\Irc\Client\React\WriteStream;

class MyWriteStream extends WriteStream
{
    /**
     * @param string $text
     *
     * @return string
     */
    public function ircCapReq($text)
    {
        $msg = $this->getGenerator()->ircCapReq($text);
        $this->emit('data', [$msg]);

        return $msg;
    }

    public function getGenerator()
    {
        if (!$this->generator) {
            $this->generator = new MyGenerator();
        }

        return $this->generator;
    }
}
