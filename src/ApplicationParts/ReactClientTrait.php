<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\ApplicationParts;

use KonstantinKuklin\StreamDefenseBot\Service\Irc\MyClient;

trait ReactClientTrait
{
    /** @var MyClient */
    private $reactClient;

    protected function initReactClient()
    {
        $this->reactClient = new MyClient();
    }

    public function getReactClient() : MyClient
    {
        return $this->reactClient;
    }
}
