<?php

namespace Craft;

class Like_LikeAssetsNotification extends BaseNotification
{
    public function event()
    {
        return 'like.addLike';
    }

    /**
     * Label of userSettings checkbox
     */
    public function getLabel()
    {
        return "Notify me when someone likes my assets";
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

            if($element->elementType != 'Asset') {
                return;
            }

            $to = $element->author;


            // send

            $variables['user'] = $liker;
            $variables['asset'] = $element;

            craft()->notifications->sendNotification($this->getHandle(), $to, $variables);
        });
    }
}