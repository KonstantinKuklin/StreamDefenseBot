<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot;


class TickPinger
{
    private $nickNameLastUpdate = [];

    private $timeout;

    public function __construct(array $nickNameList, $timeout = null)
    {
        $this->timeout = $timeout;
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
        if (!$this->timeout) {
            return false;
        }

        return time() - $this->nickNameLastUpdate[$this->getNormalizedNickName($nick)] >= $this->timeout;
    }

    private function getNormalizedNickName($nickName)
    {
        return \strtolower($nickName);
    }
}
