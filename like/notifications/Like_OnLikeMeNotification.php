<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2014, Dukt
 * @link      https://dukt.net/craft/like/
 * @license   https://dukt.net/craft/like/docs/license
 */

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
        $like = $event->params['like'];
        $sender = $like->getUser();
        $recipient = $like->getElement();

        if($recipient->elementType == 'User')
        {
            $data = array(
                'likeId' => $like->id
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

            return array(
                'like' => $like,
            );
        }
    }

    /**
     * Default Open CP Url Format
     */
    public function defaultOpenCpUrlFormat()
    {
        return '{{user.cpEditUrl}}';
    }
}