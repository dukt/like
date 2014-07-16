<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2014, Dukt
 * @link      http://dukt.net/craft/like/
 * @license   http://dukt.net/craft/like/docs/license
 */

namespace Craft;

class LikePlugin extends BasePlugin
{
    public function init()
    {
        craft()->on('entries.onBeforeDeleteEntry', function(Event $event) {

            $entry = $event->params['entry'];


            // delete likes related to this entry

            $likes = craft()->like->getLikesByElementId($entry->id);

            foreach($likes as $like)
            {
                craft()->like->deleteLikeById($like->id);
            }
        });

        craft()->on('users.onBeforeDeleteUser', function(Event $event) {

            $user = $event->params['user'];


            // delete likes where the user is liked

            $likes = craft()->like->getLikesByElementId($user->id);

            foreach($likes as $like)
            {
                craft()->like->deleteLikeById($like->id);
            }


            // delete likes of the user

            $likes = craft()->like->getLikesByUserId($user->id);

            foreach($likes as $like)
            {
                craft()->like->deleteLikeById($like->id);
            }
        });
    }

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
        return '0.9.4';
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
