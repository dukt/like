<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2015, Dukt
 * @link      https://dukt.net/craft/like/
 * @license   https://dukt.net/craft/like/docs/license
 */

namespace Craft;

class LikePlugin extends BasePlugin
{
    public function init()
    {
        craft()->on('users.onBeforeDeleteUser', function(Event $event) {
            $user = $event->params['user'];
            $userId = $user->id;

            $userIdToTransferContentTo = null;
            $userToTransferContentTo = $event->params['transferContentTo'];

            if ($userToTransferContentTo) {
                $userIdToTransferContentTo = $userToTransferContentTo->id;
                craft()->like->transferLikesByUserId($userId, $userIdToTransferContentTo);
            } else {
                craft()->like->deleteLikesByUserId($userId);
            }
        });

        craft()->on('elements.onBeforeDeleteElements', function(Event $event) {

            if(!empty($event->params['elementIds']) && is_array($event->params['elementIds']))
            {
                $elementIds = $event->params['elementIds'];

                foreach($elementIds as $elementId)
                {
                    $likes = craft()->like->getLikesByElementId($elementId);

                    foreach($likes as $like)
                    {
                        craft()->like->deleteLikeById($like->id);
                    }
                }
            }
        });
    }

    /**
     * Get Name
     */
    function getName()
    {
        return Craft::t('Like');
    }

    /**
     * Get Version
     */
    function getVersion()
    {
        return '1.0.0';
    }

    /**
    * Get SchemaVersion
    */
   public function getSchemaVersion()
   {
       return '1.0.0';
   }

    /**
     * Get Developer
     */
    function getDeveloper()
    {
        return 'Dukt';
    }

    /**
     * Get Developer URL
     */
    function getDeveloperUrl()
    {
        return 'https://dukt.net/';
    }

    /**
     * Get Settings HTML
     */
    public function getSettingsHtml()
    {
        $likes = craft()->like->getLikes();

        return craft()->templates->render('like/table', array(
            'label' => Craft::t('Pages that have been liked'),
            'instructions' => Craft::t('All columns are sortable by clicking the column heading'),
            'id'   => 'likes',
            'name' => 'likes',
            'cols' => array(
                'title' => array('heading' => Craft::t('Page title'), 'type' => 'multiline'),
                'uri' => array('heading' => Craft::t('URL'), 'type' => 'singleline', 'width' => '50%'),
                'count' => array('heading' => Craft::t('Likes'), 'type' => 'singleline', 'width' => '10%'),
            ),
            'rows' => $likes
        ));
    }

}
