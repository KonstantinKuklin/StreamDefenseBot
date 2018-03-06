<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\ApplicationParts;

use KonstantinKuklin\StreamDefenseBot\Config\BotParameters;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\NullLogger;

trait LoggerTrait
{
    /** @var Logger */
    private $logger;

    protected function initLogger(BotParameters $botParameters)
    {
        if (!$botParameters->logLevel) {
            $this->logger = new NullLogger();

            return;
        }

        $stderr = defined('\STDERR') && !\is_null(\STDERR) ? \STDERR : fopen('php://stderr', 'w');
        try {
            $logLevel = \strtoupper($botParameters->logLevel);
            if ($botParameters->logFile) {
                $stderr = \getcwd() . '/' . $botParameters->logFile;
            }
            $handler = new StreamHandler($stderr, constant('Monolog\Logger::' . $logLevel));
        } catch (\Exception $e) {
        }
        $handler->setFormatter(new LineFormatter("%datetime% %level_name% %message% %context%\n"));

        $this->logger = new Logger(get_class($this));
        $this->logger->pushHandler($handler);
    }

    public function getLogger() : Logger
    {
        return $this->logger;
    }
}
