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

class Like_OnLikeEntriesNotification extends BaseNotification
{
    /**
     * Event
     */
    public function event()
    {
        return 'like.addLike';
    }


    /**
     * Action : Send a notification when someone likes my entries
     */
    public function action(Event $event)
    {
        $contextUser = craft()->userSession->getUser();

        if(!$contextUser) {
            return;
        }

        $element = $event->params['element'];

        if($element->elementType != 'Entry') {
            return;
        }

        $user = $element->author;

        $variables['user'] = $user;
        $variables['contextUser'] = $contextUser;
        $variables['contextElement'] = $element;
        $variables['entry'] = $element;

        craft()->notifications->sendNotification($this->getHandle(), $user, $variables);
    }
}