<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot\Service;

use KonstantinKuklin\StreamDefenseBot\Config\ConnectionConfig;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

class ScreenRender
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var LogRecord[]
     */
    private $logRecordList = [];

    //    private $osDetector;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        //        $this->osDetector = new Detector();
    }

    /**
     * @param ConnectionConfig[] $connectionList
     *
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    public function render($connectionList)
    {
        $this->clearScreen();
        $table = new Table($this->output);
        $table->setHeaders(
            ['Bot Name', 'Owner', 'Started', 'Last activity', 'Follow to', 'Class', 'Location', 'Group', 'Power']
        );

        $first = true;
        foreach ($connectionList as $connectionConfig) {
            if (!$first) {
                $table->addRow(new TableSeparator());
            }
            $first = false;
            $botStatus = $connectionConfig->getBotStatus();

            $row = [
                $botStatus->nick,
                $botStatus->ownerNick,
                date('H:i:s d/m/y', $botStatus->startedAt),
                $botStatus->lastActivity ? (time() - $botStatus->lastActivity) . 's' : '-',
                $botStatus->followTo ?: '-',
                $botStatus->class ?: '-',
                $botStatus->location,
                $botStatus->group ?: '-',
                $botStatus->powerUp ?: '-',
            ];
            $table->addRow($row);

            $table->addRow(
                [
                    new TableCell('', ['colspan' => 1]),
                    new TableCell($this->getIngameStat($botStatus), ['colspan' => \count($row) - 1]),
                ]
            );
        }
        $table->render();
        $this->showRenderTime();
        $this->showMemoryUsage();
        $this->showLog();
    }

    private function clearScreen()
    {
        //        if ($this->osDetector->isUnixLike()) {
        //        } else if ($this->osDetector->isWindowsLike()) {
        //        } else {
        //        }
        $this->output->write(sprintf("\033\143"));
    }

    private function showLog()
    {
        if (!$this->logRecordList) {
            return;
        }

        $this->output->writeln('Last actions:');
        $table = new Table($this->output);
        $table->setHeaders(
            ['When', 'Bot name', 'Message', 'What found', 'Action']
        );
        foreach ($this->logRecordList as $record) {
            $table->addRow(
                [
                    date('H:i:s', $record->getCreatedAt()),
                    $record->getBotName(),
                    $record->getMessage()->author . ':' . $record->getMessage()->text,
                    $record->getWhatFound(),
                    $record->getAction(),
                ]
            );
        }
        $table->render();
    }

    private function showRenderTime()
    {
        $this->output->write('Updated: ' . date('H:i:s') . ', ');
    }

    private function showMemoryUsage()
    {
        $this->output->writeln('Memory use: ' . memory_get_usage(true) / 1024 / 1024 . 'mb');
    }

    private function getIngameStat(BotStatus $botStatus) : string
    {
        $message = '';
        foreach (BotStatus::GAME_STATS as $stat) {
            if (!$botStatus->$stat) {
                continue;
            }
            $message .= \ucfirst($stat).':'.$botStatus->$stat.' ';
        }

        return $message;
    }

    public function addLogRecord(LogRecord $record)
    {
        if (count($this->logRecordList) > 20) {
            \array_shift($this->logRecordList);
        }
        $this->logRecordList[] = $record;
    }
}
