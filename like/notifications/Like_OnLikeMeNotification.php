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

class Like_OnLikeMeNotification extends BaseNotification
{
    /**
     * Event
     */
    public function event()
    {
        return 'like.addLike';
    }


    /**
     * Action : Send a notification when someone likes me
     */
    public function action(Event $event)
    {
        $contextUser = craft()->userSession->getUser();

        if(!$contextUser) {
            return;
        }

        $element = $event->params['element'];

        if($element->elementType != 'User') {
            return;
        }

        $user = $element;

        $variables['user'] = $user;
        $variables['contextUser'] = $contextUser;

        craft()->notifications->sendNotification($this->getHandle(), $user, $variables);
    }
}