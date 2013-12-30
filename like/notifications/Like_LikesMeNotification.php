<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2013, Dukt
 * @link      http://dukt.net/craft/like/
 * @license   http://dukt.net/craft/like/docs/license
 */

namespace Craft;

class Like_LikesMeNotification extends BaseNotification
{
    /**
     * Label of userSettings checkbox
     */
    public function getLabel()
    {
        return "Notify me when someone likes me";
    }

    /**
     * Notification Action
     */
    public function getAction()
    {
        // Notify me when someone likes my content

        craft()->on('like.addLike', function(Event $event) {

            $liker = craft()->userSession->getUser();

            if(!$liker) {
                return;
            }

            $element = $event->params['element'];

            if($element->elementType != 'User') {
                return;
            }

            $toUser = $element->author;

            $notify = craft()->notifications->userHasNotification($toUser, $this->getHandle());

            if($notify) {

                // send email

                $emailModel = new EmailModel;

                $emailModel->toEmail = $toUser->email;

                $emailModel->subject = 'Someone has liked one of your entries';
                $emailModel->htmlBody = "
                A user has like one of your entries :
                <br />
                - user : {{user.email}}
                <br />
                - entry : {{entry.id}}
                <br /><br />

                ";

                $variables['user'] = $liker;
                $variables['entry'] = $element;

                craft()->email->sendEmail($emailModel, $variables);
            }
        });
    }
}