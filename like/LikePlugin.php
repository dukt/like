<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2015, Dukt
 * @link      https://dukt.net/craft/like/
 * @license   https://dukt.net/craft/like/docs/license
 */

namespace Craft;

class LikePlugin extends BasePlugin
{
    public function init()
    {
        craft()->on('elements.onBeforeDeleteElements', function(Event $event) {

            if(!empty($event->params['elementIds']) && is_array($event->params['elementIds']))
            {
                $elementIds = $event->params['elementIds'];

                foreach($elementIds as $elementId)
                {
                    $likes = craft()->like->getLikesByElementId($elementId);

                    foreach($likes as $like)
                    {
                        craft()->like->deleteLikeById($like->id);
                    }
                }
            }
        });
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
        return '0.9.7';
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
        return 'https://dukt.net/';
    }
}
