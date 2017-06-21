<?php

namespace AppBundle\Twig\Extension;

use Symfony\Bridge\Twig\Extension\AssetExtension as SymfonyAssetExtension;

class AssetExtension extends SymfonyAssetExtension
{

    public function getAssetUrl($path, $packageName = null, $absolute = false, $version = null)
    {
        $version= date('v=YmdHis');
        return parent::getAssetUrl($path, $packageName, $absolute, $version);
    }
}