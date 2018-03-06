<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SdBotCommand extends Command
{
    use LockableTrait;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return;
        }

        $application = new Application();
        $application->run($input, $output);
    }

    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Start instance of StreamDefenseBot');
    }

    public function __destruct()
    {
        $this->release();
    }
}
