<?php

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
        $liker = craft()->userSession->getUser();

        if(!$liker) {
            return;
        }

        $element = $event->params['element'];

        if($element->elementType != 'User') {
            return;
        }

        $to = $element;

        $variables['user'] = $liker;

        craft()->notifications->sendNotification($this->getHandle(), $to, $variables);
    }
}