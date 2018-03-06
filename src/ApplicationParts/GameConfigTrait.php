<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\ApplicationParts;

use KonstantinKuklin\StreamDefenseBot\Config\GameConfig;

trait GameConfigTrait
{
    private $gameConfig;

    /**
     * @param string[] $gameConfig
     */
    protected function initGameConfig(array $gameConfig)
    {
        $this->gameConfig = new GameConfig($gameConfig);
    }

    public function getGameConfig() : GameConfig
    {
        return $this->gameConfig;
    }
}
