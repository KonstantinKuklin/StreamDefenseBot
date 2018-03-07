<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\ApplicationParts;

use KonstantinKuklin\StreamDefenseBot\TickPinger;

trait TickPingerTrait
{
    /** @var TickPinger */
    private $tickPinger;

    /**
     * @param string[] $nickNameList
     */
    protected function initTickPinger(array $nickNameList, $timeout)
    {
        $this->tickPinger = new TickPinger($nickNameList, $timeout);
    }

    public function getTickPinger() : TickPinger
    {
        return $this->tickPinger;
    }
}
