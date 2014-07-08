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
        $data = $this->getDataFromEvent($event);
        $variables = $this->getVariables($data);
        $recipient = $variables['like']->getElement();

        if($recipient->elementType == 'User')
        {
            $sender = $variables['sender'];
            $relatedElement = $variables['like'];

            // send notification
            craft()->notifications->sendNotification($this->getHandle(), $recipient, $sender, $relatedElement, $data);
        }
    }

    /**
     * Get variables
     */
    public function getVariables($data = array())
    {
        if(!empty($data['likeId']))
        {
            $like = craft()->like->getLikeById($data['likeId']);
            $sender = $like->getUser();

            return array(
                'sender' => $sender,
                'like' => $like,
            );
        }
    }

    /**
     * Get data from event
     */
    public function getDataFromEvent(Event $event)
    {
        $like = $event->params['like'];
        $sender = $like->getUser();

        return array(
            'likeId' => $like->id,
            'senderId' => $sender->id
        );
    }

    /**
     * Default Open CP Url Format
     */
    public function defaultOpenCpUrlFormat()
    {
        return '{{user.cpEditUrl}}';
    }
}