<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\ApplicationParts;

use KonstantinKuklin\StreamDefenseBot\Service\ScreenRender;
use Symfony\Component\Console\Output\OutputInterface;

trait ScreenRenderTrait
{
    private $screenRender;

    protected function initScreenRender(OutputInterface $output)
    {
        $this->screenRender = new ScreenRender($output);
    }

    /**
     * @return ScreenRender
     */
    public function getScreenRender()
    {
        return $this->screenRender;
    }
}
