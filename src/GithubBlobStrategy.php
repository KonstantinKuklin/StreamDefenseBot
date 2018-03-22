<?php

/**
 * @maintainer Konstantin Kuklin <konstantin.kuklin@gmail.com>
 */

namespace KonstantinKuklin\StreamDefenseBot;

use Humbug\SelfUpdate\Exception\JsonParsingException;
use Humbug\SelfUpdate\Strategy\GithubStrategy;
use Humbug\SelfUpdate\Updater;
use Humbug\SelfUpdate\VersionParser;

class GithubBlobStrategy extends GithubStrategy
{
    /**
     * @var string
     */
    private $remoteVersion;

    /**
     * @var string
     */
    private $remoteUrl;

    /**
     * Retrieve the current version available remotely.
     *
     * @param Updater $updater
     *
     * @return string|bool
     */
    public function getCurrentRemoteVersion(Updater $updater)
    {
        /** Switch remote request errors to HttpRequestExceptions */
        set_error_handler([$updater, 'throwHttpRequestException']);
        $packageUrl = $this->getApiUrl();
        $package = json_decode(humbug_get_contents($packageUrl), true);
        restore_error_handler();

        if (null === $package || json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonParsingException(
                'Error parsing JSON package data'
                . (function_exists('json_last_error_msg') ? ': ' . json_last_error_msg() : '')
            );
        }

        $versions = array_keys($package['package']['versions']);
        $versionParser = new VersionParser($versions);
        if ($this->getStability() === self::STABLE) {
            $this->remoteVersion = $versionParser->getMostRecentStable();
        } elseif ($this->getStability() === self::UNSTABLE) {
            $this->remoteVersion = $versionParser->getMostRecentUnstable();
        } else {
            $this->remoteVersion = $versionParser->getMostRecentAll();
        }

        /**
         * Setup remote URL if there's an actual version to download
         */
        if (!empty($this->remoteVersion)) {
            $this->remoteUrl = $this->getDownloadUrl($package);
        }

        parent::getCurrentRemoteVersion($updater);
        return $this->remoteVersion;
    }

    protected function getDownloadUrl(array $package)
    {
        $baseUrl = preg_replace(
            '{\.git$}',
            '',
            $package['package']['versions'][$this->remoteVersion]['source']['url']
        );
        $downloadUrl = sprintf(
            '%s/raw/%s/%s',
            $baseUrl,
            $this->remoteVersion,
            $this->getPharName()
        );

        return $downloadUrl;
    }
}
//https://github.com/KonstantinKuklin/StreamDefenseBot/raw/0.1.0/sdbot.phar
