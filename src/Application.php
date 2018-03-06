<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot;


use InvalidArgumentException;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\ConnectionTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\DispatcherTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\GameConfigTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\IOTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\LoggerTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\ReactClientTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\ScreenRenderTrait;
use KonstantinKuklin\StreamDefenseBot\ApplicationParts\TickPingerTrait;
use KonstantinKuklin\StreamDefenseBot\Config\BotParameters;
use KonstantinKuklin\StreamDefenseBot\Event\ClientConfigureEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class Application
{
    use DispatcherTrait;
    use TickPingerTrait;
    use ReactClientTrait;
    use GameConfigTrait;
    use ConnectionTrait;
    use LoggerTrait;
    use IOTrait;
    use ScreenRenderTrait;
    private $botParameters;

    protected function loadConfig()
    {
        if (\file_exists(\getcwd() . '/config/config.yaml')) {
            $configList = Yaml::parseFile(\getcwd() . '/config/config.yaml');
        } elseif (\file_exists(\getcwd() . '/config.yaml')) {
            $configList = Yaml::parseFile(\getcwd() . '/config.yaml');
        } else {
            throw new InvalidArgumentException(
                'Can`t find config file in ' . \getcwd() . '/config.yaml and ' . \getcwd() . '/config/config.yaml'
            );
        }
        $this->initGameConfig($configList['game']);

        $botParameters = new BotParameters();
        $botParameters->logFile = $configList['bot_parameters']['log_file'];
        $botParameters->logLevel = $configList['bot_parameters']['log_level'];
        $this->botParameters = $botParameters;

        return $configList;
    }

    protected function init()
    {
        $configList = $this->loadConfig();
        $botList = $configList['bots'];

        $botNames = array_map(function ($botConfig) {
            return $botConfig['login'];
        }, $botList);

        $this->initTickPinger($botNames);
        $this->initReactClient();
        $this->initScreenRender($this->output);
        $this->initEventListener();
        $this->initConnectionList($botList);
        $this->initLogger($this->botParameters);
        $this->reactClient->setLogger($this->logger); // redefine logger

        $this->dispatcher->dispatch('client.configure', new ClientConfigureEvent($this->reactClient, $this));
    }

    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->initIO($input, $output);
        $this->init();
        $this->reactClient->run($this->connectionList);
    }
}
