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

    public function getUrl($notification)
    {
        $element = craft()->elements->getElementById($notification->contextElementId);

        if(method_exists($element, 'getCpEditUrl'))
        {
            return $element->getCpEditUrl();
        }
    }
}