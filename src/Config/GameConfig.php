<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Config;

class GameConfig
{
    private $channel;

    private $ttdbot;

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return string
     */
    public function getTtdbot()
    {
        return $this->ttdbot;
    }

    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            if(\property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
