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

        } else {
            // already a fav
        }
    }

    public function remove($elementId, $userId)
    {
        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => $userId
        );

        $record = LikeRecord::model()->find($conditions, $params);

        if ($record) {
            $record->delete();
        }
    }



    public function getLikes($elementId = null)
    {
        $likes = array();


        // find likes

        $conditions = 'elementId=:elementId';

        $params = array(':elementId' => $elementId);

        $records = LikeRecord::model()->findAll($conditions, $params);

        foreach($records as $record) {
            array_push($likes, $record);
        }

        return $likes;
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
}