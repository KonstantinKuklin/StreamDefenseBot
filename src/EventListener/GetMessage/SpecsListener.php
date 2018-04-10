<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;
use KonstantinKuklin\StreamDefenseBot\Service\LogRecord;
use KonstantinKuklin\StreamDefenseBot\Service\ScreenRenderInjectTrait;

class SpecsListener
{
    use ScreenRenderInjectTrait;

    /**
     * @param MessageEvent $event
     *
     * @throws \Exception
     */
    public function handle(MessageEvent $event)
    {
        $text = $event->getMessage()->text;
        $author = $event->getMessage()->author;

        if ($author === 'ttdbot') {
            $matches = [];
            \preg_match('/\[Rank [\d]* [\w]+\]/ui', $text, $matches);
            if (!$matches) {
                return;
            }

            $this->screenRender->addLogRecord(new LogRecord(
                $event->getConnection()->getBotStatus()->nick,
                $event->getMessage(),
                'specs',
                'write specs'
            ));

            $event->setTextToWrite($text);
        }
    }
}
