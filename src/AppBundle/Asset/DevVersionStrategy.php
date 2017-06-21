<?php

namespace AppBundle\Asset;

use Symfony\Component\Asset\VersionStrategy\VersionStrategyInterface;

// DOC: http://symfony.com/doc/current/frontend/custom_version_strategy.html

class DevVersionStrategy implements VersionStrategyInterface
{
    public function getVersion($path)
    {
        return date('v=YmdHis');
    }

    public function applyVersion($path)
    {
        $version = $this->getVersion($path);

        if ('' === $version) {
            return $path;
        }

        $versionized = sprintf('%s?%s', ltrim($path, '/'), $version);

        if ($path && '/' === $path[0]) {
            return '/' . $versionized;
        }

        return $versionized;
    }
}