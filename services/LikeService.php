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

        if (!$record)
        {
            $model = new LikeModel();
            $model->elementId = $elementId;
            $model->userId = $userId;

            $record = new LikeRecord;
            $record->elementId = $model->elementId;
            $record->userId = $model->userId;

            $record->validate();
            $model->addErrors($record->getErrors());

            if(!$model->hasErrors())
            {
                $record->save(false);
                $model->id = $record->id;

                $this->onAddLike(new Event($this, array(
                    'like' => $model
                )));
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


            // delete like

            $record->delete();

            $this->onRemoveLike(new Event($this, array(
                'like' => $like
            )));
        }

        return true;
    }

    public function transferLikesByUserId($userId, $userIdToTransferContentTo)
    {
        $conditions = 'userId=:userId';

        $params = array(
            ':userId' => $userId
        );

        $records = LikeRecord::model()->findAll($conditions, $params);

        foreach($records as $record) {
            $like = LikeModel::populateModel($record);

            $elementId = $record->elementId;

            // delete original like
            $record->delete();

            // create like on new user
            $this->add($elementId, $userIdToTransferContentTo);
        }

        return true;
    }

    public function deleteLikesByUserId($userId)
    {
        $conditions = 'userId=:userId';

        $params = array(
            ':userId' => $userId
        );

        $records = LikeRecord::model()->findAll($conditions, $params);

        foreach($records as $record) {
            $like = LikeModel::populateModel($record);

            // delete like
            $record->delete();

            $this->onRemoveLike(new Event($this, array(
                'like' => $like
            )));
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
        $conditions = 'elementId=:elementId';

        $params = array(':elementId' => $elementId);

        $records = LikeRecord::model()->findAll($conditions, $params);

        return LikeModel::populateModels($records);
    }

    public function getLikes($elementId = null)
    {
        if ($elementId) {
            return $this->getLikesByElementId($elementId);
        } else {
            $likes = array();

            // It'd be nice to use the model, but grouping seems to be problematic
            // $records = LikeRecord::model()->findAll(array(
            //     'select' => 'COUNT(elementId) AS count, elementId',
            //     'group' => 'elementId'
            // ));

            $query = craft()->db->createCommand();
            $records = $query
                ->select('COUNT(elementId) AS count, elementId')
                ->from('likes')
                ->group('elementId')
                ->order('count DESC')
                ->queryAll();

            foreach($records as $record) {

                $element = craft()->elements->getElementById($record['elementId']);

                if($element) {
                    array_push($likes, array(
                        'title' => $element->title,
                        'uri' => $element->uri,
                        'count' => $record['count']
                    ));
                }
            }

            return $likes;
        }
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

            $element = craft()->elements->getElementById($record->elementId, $elementType);

            if($element) {
                array_push($likes, $element);
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

    public function onRemoveLike(Event $event)
    {
        $this->raiseEvent('onRemoveLike', $event);
    }
}