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
        craft()->on('entries.onDeleteEntry', function(Event $event) {
            // delete notifications with entryId
            craft()->notifications->deleteNotifications('entryId', $event->params['entry']->id);
        });

        craft()->on('users.onDeleteUser', function(Event $event) {
            // delete notifications with senderId
            craft()->notifications->deleteNotifications('senderId', $event->params['user']->id);
        });

        craft()->on('like.onRemoveLike', function(Event $event) {
            // delete notifications with likeId
            craft()->notifications->deleteNotifications('likeId', $event->params['like']->id);
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