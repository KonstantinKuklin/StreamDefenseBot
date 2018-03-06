#!/usr/bin/env php
<?php

if (version_compare('7.0.0', PHP_VERSION, '>')) {
    echo 'This version of SdBot requires PHP 7.0.0 or upper'.PHP_EOL;
    exit(1);
}

require __DIR__ . '/../vendor/autoload.php';

use KonstantinKuklin\StreamDefenseBot\SdBotCommand;
use KonstantinKuklin\StreamDefenseBot\SelfUpdateCommand;
use Symfony\Component\Console\Application;

$sdBotCommand = new SdBotCommand('run');
$selfUpdateCommand = new SelfUpdateCommand('selfupdate');

$application = new Application('sdbot');
$application->add($selfUpdateCommand);
$application->add($sdBotCommand);
//$application->setDefaultCommand($sdBotCommand->getName());
$application->run();
