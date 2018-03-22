<?php

if (version_compare('7.0.0', PHP_VERSION, '>')) {
    echo 'This version of SdBot requires PHP 7.0.0 or upper' . PHP_EOL;
    exit(1);
}

/** @var \Composer\Autoload\ClassLoader */
$composerLoader = require __DIR__ . '/../vendor/autoload.php';

use Composer\Command\CheckPlatformReqsCommand;
use Composer\IO\ConsoleIO;
use KonstantinKuklin\StreamDefenseBot\SdBotCommand;
use KonstantinKuklin\StreamDefenseBot\SelfUpdateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

$sdBotCommand = new SdBotCommand('run');
$selfUpdateCommand = new SelfUpdateCommand('selfupdate');
$checkPlatformReq = new CheckPlatformReqsCommand('check-platform-reqs');

$application = new Application('sdbot');

$consoleIO = new ConsoleIO(
    new ArgvInput(),
    new ConsoleOutput(),
    $application->getHelperSet()
);

$composerFile = __DIR__ . '/../composer.json';
$versionFile = __DIR__ . '/../version.php';
$baseDir = __DIR__ . '/..';

$composerFactory = new \Composer\Factory();
$composer = $composerFactory->createComposer($consoleIO, $composerFile, false, $baseDir);
$oldRepositoryManager = $composer->getRepositoryManager();
$config = $composer->getConfig();
$config->getRepositories();

$repositoryManager = \Composer\Repository\RepositoryFactory::manager($consoleIO, $config, $composer->getEventDispatcher());
$composer->setRepositoryManager($repositoryManager);
$checkPlatformReq->setComposer($composer);

if (!file_exists($versionFile)) {
    $process = new Process('git log --pretty="%H" -n1 HEAD', __DIR__);
    if ($process->run() != 0) {
        throw new \RuntimeException('Can\'t run git log. You must ensure to run compile from sdbot git repository clone and that git binary is available.');
    }
    $application->setVersion(trim($process->getOutput()));
} else {
    $version = trim(include $versionFile);
    $application->setVersion($version);
}

$application->add($selfUpdateCommand);
$application->add($sdBotCommand);
$application->add($checkPlatformReq);

$application->run();
