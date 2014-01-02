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

class Like_LikesMeNotification extends BaseNotification
{
    /**
     * Label of userSettings checkbox
     */
    public function getLabel()
    {
        return "Notify me when someone likes me";
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

            if($element->elementType != 'User') {
                return;
            }

            $to = $element;


            // send

            $variables['user'] = $liker;

            craft()->notifications->sendNotification($this->getHandle(), $to, $variables);
        });
    }
}