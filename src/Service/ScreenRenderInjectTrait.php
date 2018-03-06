<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service;


trait ScreenRenderInjectTrait
{
    /** @var ScreenRender */
    private $screenRender;

    public function setScreenRender(ScreenRender $screenRender)
    {
        $this->screenRender = $screenRender;
    }
}
