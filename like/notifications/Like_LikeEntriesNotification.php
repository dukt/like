<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2013, Dukt
 * @link      http://dukt.net/craft/like/
 * @license   http://dukt.net/craft/like/docs/license
 */

namespace Craft;

class Like_LikeEntriesNotification extends BaseNotification
{
    /**
     * Label of userSettings checkbox
     */
    public function getLabel()
    {
        return "Notify me when someone likes my entries";
    }


    /**
     * Send Notification
     */
    public function send()
    {
        // Notify me when someone likes my content

        craft()->on('like.addLike', function(Event $event) {

            $liker = craft()->userSession->getUser();

            if(!$liker) {
                return;
            }

            $element = $event->params['element'];

            if($element->elementType != 'Entry') {
                return;
            }

            $to = $element->author;

            $variables['user'] = $liker;
            $variables['entry'] = $element;

            craft()->notifications->sendNotification($this->getHandle(), $to, $variables);
        });
    }
}