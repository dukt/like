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


    public function getLikesImproved($elementType = null)
    {
        $conditions = 'userId=:userId';

        $params = array(
            ':userId' => craft()->userSession->getUser()->id
        );

        $records = LikeRecord::model()->findAll($conditions, $params);

        return $records;
    }

    public function getLikes($elementType = null)
    {
        $conditions = 'userId=:userId';

        $params = array(
            ':userId' => craft()->userSession->getUser()->id
        );

        $likes = array();

        switch($elementType) {
            case "User":

                $records = LikeRecord::model()->findAll($conditions, $params);

                foreach($records as $record) {

                    if($record->element->type == $elementType) {
                        $likeElement = craft()->users->getUserById($record->elementId);

                        array_push($likes, $likeElement);
                    }
                }

                break;

            case "Entry":

                $records = LikeRecord::model()->findAll($conditions, $params);

                foreach($records as $record) {

                    if($record->element->type == $elementType) {
                        $likeElement = craft()->entries->getEntryById($record->elementId);

                        array_push($likes, $likeElement);
                    }
                }

                break;

        }

        return $likes;
    }

    public function isLike($elementId)
    {
        $conditions = 'elementId=:elementId and userId=:userId';

        $params = array(
            ':elementId' => $elementId,
            ':userId' => craft()->userSession->getUser()->id
        );

        $record = LikeRecord::model()->find($conditions, $params);

        if($record) {
            return true;
        }

        return false;
    }
}