<?php

/**
 * Craft Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2015, Dukt
 * @link      https://dukt.net/craft/like/
 * @license   https://dukt.net/craft/like/docs/license
 */

namespace dukt\like\assetbundles\Like;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class LikeAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@dukt/like/assetbundles/like/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/tablesort.js',
            'js/tablesort.number.js',
            'js/init.js',
        ];

        $this->css = [
            'css/tablesort.css',
        ];

        parent::init();
    }
}
