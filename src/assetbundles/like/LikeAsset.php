<?php
/**
 * Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @link      https://github.com/benjamindavid
 * @copyright Copyright (c) 2018 Benjamin David
 */

namespace dukt\like\assetbundles\Like;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Benjamin David
 * @package   Like
 * @since     1.0.0
 */
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
            'js/init.js',
            'js/tablesort.js',
            'js/tablesort.number.js',
        ];

        $this->css = [
            'css/tablesort.css',
        ];

        parent::init();
    }
}
