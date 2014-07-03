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
        $user = craft()->userSession->getUser();

        if(!$user) {
            return;
        }

        $element = $event->params['element'];

        if($element->elementType != 'Entry') {
            return;
        }


        // data
        $data = array(
            'entryId' => $element->id,
            'userId' => $user->id
        );

        // recipient
        $recipient = $element->author;

        // // variables
        // $variables = $this->getVariables($data);
        // $variables['recipient'] = $recipient;

        // send notification
        craft()->notifications->sendNotification($this->getHandle(), $recipient, $data);
    }

    public function getVariables($data = array())
    {
        $variables = $data;

        if(!empty($data['entryId']))
        {
            $variables['entry'] = craft()->elements->getElementById($data['entryId']);
        }

        if(!empty($data['userId']))
        {
            $variables['user'] = craft()->elements->getElementById($data['userId']);
        }

        return $variables;
    }

    public function defaultOpenUrl()
    {
        return "{{ entry.url }}";
    }

    public function defaultOpenCpUrl()
    {
        return "{{ entry.cpEditUrl }}";
    }
}