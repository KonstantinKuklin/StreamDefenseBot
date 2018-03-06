<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot;


class TickPinger
{
    const TIMEOUT = 240;

    private $nickNameLastUpdate = [];

    public function __construct(array $nickNameList)
    {
        foreach ($nickNameList as $nickName) {
            $this->nickNameLastUpdate[$this->getNormalizedNickName($nickName)] = time();
        }
    }

    public function update($nick)
    {
        $this->nickNameLastUpdate[$this->getNormalizedNickName($nick)] = time();
    }

    public function isTimeOuted($nick)
    {
        return time() - $this->nickNameLastUpdate[$this->getNormalizedNickName($nick)] >= self::TIMEOUT;
    }

    private function getNormalizedNickName($nickName)
    {
        return \strtolower($nickName);
    }
}
