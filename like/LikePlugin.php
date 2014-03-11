<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2014, Dukt
 * @link      https://dukt.net/craft/like/
 * @license   https://dukt.net/craft/like/docs/license
 */

namespace Craft;

class LikePlugin extends BasePlugin
{
    public function enableNotifications()
    {
        return true;
    }

    /**
     * Get Name
     */
    function getName()
    {
        return Craft::t('Like');
    }

    /**
     * Get Version
     */
    function getVersion()
    {
        return '0.9.2';
    }

    /**
     * Get Developer
     */
    function getDeveloper()
    {
        return 'Dukt';
    }

    /**
     * Get Developer URL
     */
    function getDeveloperUrl()
    {
        return 'http://dukt.net/';
    }
}