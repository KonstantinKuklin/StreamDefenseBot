<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service\Irc;


use Phergie\Irc\Client\React\ReadStream;

class MyReadStream extends ReadStream
{
    public function getParser()
    {
        if (!$this->parser) {
            $this->parser = new MyParser();
        }
        return $this->parser;
    }
}
