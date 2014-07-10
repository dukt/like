<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2014, Dukt
 * @link      http://dukt.net/craft/like/
 * @license   http://dukt.net/craft/like/docs/license
 */

namespace Craft;

class LikeService extends BaseApplicationComponent
{
    public function add($likeElementId, $userId)
    {
        $validateContent = false;

        $conditions = 'likeElementId=:likeElementId and userId=:userId';

        $params = array(
            ':likeElementId' => $likeElementId,
            ':userId' => $userId
        );

        $record = LikeRecord::model()->find($conditions, $params);

        if (!$record)
        {
            $model = new LikeModel();
            $model->likeElementId = $likeElementId;
            $model->userId = $userId;

            $record = new LikeRecord;
            $record->likeElementId = $model->likeElementId;
            $record->userId = $model->userId;

            $record->validate();
            $model->addErrors($record->getErrors());

            if(!$model->hasErrors())
            {
                if(craft()->elements->saveElement($model, $validateContent))
                {
                    $record->id = $model->id;
                    $record->save(false);

                    $this->onAddLike(new Event($this, array(
                        'like' => $model
                    )));

                    return true;
                }
            }
        }
        else
        {
            // already a fav
        }

        return true;
    }

    public function deleteLikeById($id)
    {
        $record = LikeRecord::model()->findByPk($id);

        if ($record)
        {
            $like = LikeModel::populateModel($record);

            if(isset(craft()->notifications))
            {
                // remove notification related to this like

                $notifications = array();

                $notifications = array_merge($notifications, craft()->notifications->findNotificationsByData('like.onlikeentries', 'likeId', $like->id));

                $notifications = array_merge($notifications, craft()->notifications->findNotificationsByData('like.onlikeme', 'likeId', $like->id));

                foreach($notifications as $notification)
                {
                    craft()->notifications->deleteNotificationById($notification->id);
                }
            }

            // delete like element

            craft()->elements->deleteElementById($like->id);

            $this->onRemoveLike(new Event($this, array(
                'like' => $like
            )));
        }

        return true;
    }

    public function remove($likeElementId, $userId)
    {
        $conditions = 'likeElementId=:likeElementId and userId=:userId';

        $params = array(
            ':likeElementId' => $likeElementId,
            ':userId' => $userId
        );

        $record = LikeRecord::model()->find($conditions, $params);

        if ($record)
        {
            $this->deleteLikeById($record->id);
        }

        return true;
    }

    public function getLikeById($id)
    {
        $record = LikeRecord::model()->findByPk($id);

        if($record)
        {
            return LikeModel::populateModel($record);
        }
    }

    public function getLikesByElementId($elementId)
    {
        $conditions = 'likeElementId=:likeElementId';

        $params = array(':likeElementId' => $elementId);

        $records = LikeRecord::model()->findAll($conditions, $params);

        return LikeModel::populateModels($records);
    }

    public function getLikes($likeElementId = null)
    {
        return $this->getLikesByElementId($likeElementId);
    }

    public function getLikesByUserId($userId)
    {
        $conditions = 'userId=:userId';

        $params = array(
            ':userId' => $userId
        );

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

            $likeElement = craft()->elements->getElementById($record->likeElementId, $elementType);

            if($likeElement) {
                array_push($likes, $likeElement);
            }
        }

        return $likes;
    }

    public function isLike($likeElementId)
    {
        if(craft()->userSession->isLoggedIn()) {
            $userId = craft()->userSession->getUser()->id;
        } else {
            return false;
        }

        $userId = craft()->userSession->getUser()->id;

        $conditions = 'likeElementId=:likeElementId and userId=:userId';

        $params = array(
            ':likeElementId' => $likeElementId,
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

    public function onRemoveLike(Event $event)
    {
        $this->raiseEvent('onRemoveLike', $event);
    }
}