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
        $like = $event->params['like'];

        if($like->getElement()->elementType == 'Entry')
        {
            $entry = $like->getElement();
            $sender = $like->getUser();
            $recipient = $entry->author;

            // data
            $data = array(
                'likeId' => $like->id,
                'entryId' => $like->elementId
            );

            // send notification
            craft()->notifications->sendNotification($this->getHandle(), $recipient, $sender, $data);
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

            if($like)
            {
                $entry = $like->getElement();

                return array(
                    'entry' => $entry,
                    'like' => $like,
                );
            }
        }

        return array();
    }

    /**
     * Default Open Url Format
     */
    public function defaultOpenUrlFormat()
    {
        return '{{entry.url}}';
    }

    /**
     * Default Open CP Url Format
     */
    public function defaultOpenCpUrlFormat()
    {
        return '{{entry.cpEditUrl}}';
    }
}