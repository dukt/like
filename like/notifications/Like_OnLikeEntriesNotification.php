<?php

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
    }
}