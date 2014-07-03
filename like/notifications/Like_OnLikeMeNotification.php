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
        $user = craft()->userSession->getUser();

        if(!$user) {
            return;
        }

        $element = $event->params['element'];

        if($element->elementType != 'User') {
            return;
        }

        // recipient
        $recipient = $element;

        // data
        $data = array(
            'elementId' => $element->id,
            'userId' => $user->id
        );

        // send notification
        craft()->notifications->sendNotification($this->getHandle(), $recipient, $data);
    }

    public function getVariables($data = array())
    {
        $variables = $data;

        if(!empty($data['elementId']))
        {
            $variables['element'] = craft()->elements->getElementById($data['elementId']);
        }

        if(!empty($data['userId']))
        {
            $variables['user'] = craft()->elements->getElementById($data['userId']);
        }

        return $variables;
    }
}