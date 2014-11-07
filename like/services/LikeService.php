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

class LikeService extends BaseApplicationComponent
{
    public function add($elementId, $userId)
    {
        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => $userId
        );

        $record = LikeRecord::model()->find($conditions, $params);

        if (!$record) {

            // add fav

            $record = new LikeRecord;
            $record->elementId = $elementId;
            $record->userId = $userId;
            $record->save();


            // event

            $element = craft()->elements->getElementById($elementId);

            $this->onAddLike(new Event($this, array(
                'element' => $element
            )));

        } else {
            // already a fav
        }

        return true;
    }

    public function remove($elementId, $userId)
    {
        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => $userId
        );

        $record = LikeRecord::model()->find($conditions, $params);

        if ($record)
        {
            $record->delete();
        }

        return true;
    }

    public function getLikes($elementId = null)
    {
        // find likes

        $conditions = 'elementId=:elementId';

        $params = array(':elementId' => $elementId);

        $records = LikeRecord::model()->findAll($conditions, $params);

        return LikeModel::populateModels($records);
    }

    public function getUserLikes($elementType = null, $userId = null)
    {
        $likes = array();

        if(!$userId && craft()->userSession->isLoggedIn()) {
                $userId = craft()->userSession->getUser()->id;
        }

        if(!$userId) {
            return $likes;
        }


        // find likes

        $conditions = 'userId=:userId';

        $params = array(
            ':userId' => $userId
        );

        $records = LikeRecord::model()->findAll($conditions, $params);

        foreach($records as $record) {

            $likeElement = craft()->elements->getElementById($record->elementId, $elementType);

            if($likeElement) {
                array_push($likes, $likeElement);
            }
        }

        return $likes;
    }

    public function isLike($elementId)
    {
        if(craft()->userSession->isLoggedIn()) {
            $userId = craft()->userSession->getUser()->id;
        } else {
            return false;
        }

        $userId = craft()->userSession->getUser()->id;

        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => $userId
        );

        $record = LikeRecord::model()->find($conditions, $params);

        if($record) {
            return true;
        }

        return false;
    }

    public function onAddLike(Event $event)
    {
        $this->raiseEvent('onAddLike', $event);
    }
}