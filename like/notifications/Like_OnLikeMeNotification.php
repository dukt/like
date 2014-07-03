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

        $recipient = $element;

        $variables['recipient'] = $recipient;
        $variables['user'] = $user;

        craft()->notifications->sendNotification($this->getHandle(), $recipient, $variables);
    }

    // public function actionMarkAsRead();
    // public function actionArchive();
    // public function actionView();
    // public function actionCpEdit();

    public function getOpenCpUrl()
    {
        return "{{ entry.cpEditUrl }}";
    }
}