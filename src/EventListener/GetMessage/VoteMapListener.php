<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\EventListener\GetMessage;

use KonstantinKuklin\StreamDefenseBot\Event\MessageEvent;

class VoteMapListener
{
    /**
     * @param MessageEvent $event
     *
     * @throws \Exception
     */
    public function handle(MessageEvent $event)
    {
        $message = $event->getMessage()->message;
        $messageAuthor = $event->getMessage()->nick;
        $connection = $event->getConnection();
        $ttdBotNick = 'ttdbot';
        $mapVoteLast = (int)$connection->getOption('map_vote_last');

        if ($messageAuthor === $ttdBotNick && $event->getConnection()->getBotStatus()->isMapVoteAllowed) {
            $matches = [];
            \preg_match('/now in the lead!/ui', $message, $matches);
            if (!$matches) {
                return;
            }

            if (time() - 60 > $mapVoteLast) {
                $connection->setOption('map_vote_last', time());
                $event->setTextToWrite('!map' . random_int(1, 9));
            }
        }
    }
}
