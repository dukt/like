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
    public function getName()
    {
        return Craft::t('Like');
    }

    /**
     * Get Version
     */
    public function getVersion()
    {
        return '1.0.1';
    }

    /**
    * Get SchemaVersion
    */
   public function getSchemaVersion()
   {
       return '1.0.0';
   }

    /**
     * Get Developer
     */
    public function getDeveloper()
    {
        return 'Dukt';
    }

    /**
     * Get Developer URL
     */
    public function getDeveloperUrl()
    {
        return 'https://dukt.net/';
    }

    /**
     * Get release feed URL
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/dukt/like/v1/releases.json';
    }
}
