<?php
/**
 * Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @link      https://github.com/benjamindavid
 * @copyright Copyright (c) 2018 Benjamin David
 */

namespace dukt\like\services;

use dukt\like\Like;
use dukt\like\models\LikeModel;
use dukt\like\records\LikeRecord;
use dukt\like\events\LikeEvent;

use Craft;
use craft\base\Component;
use craft\db\Query;
use craft\helpers\DateTimeHelper;

/**
 * @author    Benjamin David
 * @package   Like
 * @since     1.0.0
 */
class LikeService extends Component
{
    // Constants
    // =========================================================================
    /**
     * @event AddLikeEvent The event that is triggered when a like is added
     */
    const EVENT_ON_ADD_LIKE = 'onAddLike';

    /**
     * @event RemoveLikeEvent The event that is triggered when a like is removed
     */
    const EVENT_ON_REMOVE_LIKE = 'onRemoveLike';

    // Public Methods
    // =========================================================================

    /*
     * Add a record to the database representing the like
     *
     * @param mixed $elementId
     * @param mixed $userId
     * @return boolean
     */
    public function add($elementId, $userId)
    {
        $params = array(
            'userId' => $userId,
            'elementId' => $elementId
        );

        $record = LikeRecord::find()->where($params)->one();

        if (!$record) {
            $model = new LikeModel();
            $model->elementId = $elementId;
            $model->userId = $userId;

            $record = new LikeRecord;
            $record->elementId = $model->elementId;
            $record->userId = $model->userId;

            $record->validate();
            $model->addErrors($record->getErrors());

            if (!$model->hasErrors()) {
                $record->save(false);
                $model->id = $record->id;

                $this->onAddLike($model);
            }
        } else {
            // already a fav
        }

        return true;
    }

    /*
     * Remove a Like from the database using the supplied $id
     *
     * @param mixed $id
     * @return boolean
     */
    public function deleteLikeById($id)
    {
        $params = [
            'id' => $id,
        ];

        $record = LikeRecord::find()->where($params)->one();

        if ($record) {
            $model = new LikeModel();
            $model->id = $record->id;
            $model->elementId = $record->elementId;
            $model->userId = $record->userId;

            // delete like
            $record->delete();

            $this->onRemoveLike($model);
        }

        return true;
    }

    /**
     * Remove a Like from the database matching the supplied $elementId and $userId
     *
     * @param mixed $elementId
     * @param mixed $userId
     * @return boolean
     */
    public function remove($elementId, $userId)
    {
        $params = [
            'elementId' => $elementId,
            'userId' => $userId,
        ];

        $record = LikeRecord::find()->where($params)->one();

        if ($record) {
            $this->deleteLikeById($record->id);
        }

        return true;
    }

    /**
     * Return a LikeModel for a Like matching the supplied $id
     *
     * @param mixed $id
     * @return mixed LikeModel
     */
    public function getLikeById($id)
    {
        $params = [
            'id' => $id,
        ];

        $record = LikeRecord::find()->where($params)->one();

        if ($record) {
            return LikeModel::populateModel($record);
        }
    }

    /**
     * Return an array of LikeModels for Likes matching the supplied $elementId
     *
     * @param mixed $elementId
     * @return array of LikeModels
     */
    public function getLikesByElementId($elementId)
    {
        $records = LikeRecord::findAll([
            'elementId' => $elementId
        ]);

        return LikeModel::populateModels($records);
    }

    /**
     * Return either an array of LikeModels for Likes matching the supplied $elementId
     * or an array of all Likes.
     *
     * @param mixed $elementId (optional)
     * @return array
     */
    public function getLikes($elementId = null)
    {
        if ($elementId) {
            return $this->getLikesByElementId($elementId);
        } else {
            $likes = [];

            // It'd be nice to use the model, but grouping seems to be problematic
            // $records = LikeRecord::findAll(array(
            //     'select' => 'COUNT(elementId) AS count, elementId',
            //     'group' => 'elementId'
            // ));
            $records = (new Query())
                ->select('COUNT(elementId) AS count, elementId')
                ->from('likes')
                ->groupBy('elementId')
                ->orderBy('count DESC')
                ->all();

            foreach ($records as $record) {
                $element = Craft::$app->getElements()->getElementById($record['elementId']);

                if ($element) {
                    array_push($likes, [
                        'title' => $element->title,
                        'uri' => $element->uri,
                        'count' => $record['count'],
                    ]);
                }
            }

            return $likes;
        }
    }

    /**
     * Return an array of LikeModels for Likes matching the supplied $userId
     *
     * @param mixed $userId
     * @return array of LikeModels
     */
    public function getLikesByUserId($userId)
    {
        $records = LikeRecord::findAll([
            'userId' => $userId
        ]);

        return LikeModel::populateModels($records);
    }

    /**
     * Return an array of Likes matching the $userId (if supplied)
     * or for the current logged-in user.
     *
     * @param [type] $elementType
     * @param [type] $userId
     * @return void
     */
    public function getUserLikes($elementType = null, $userId = null)
    {
        $likes = [];
        $userId = $userId  ?? Craft::$app->getUser()->id;

        if (!$userId) {
            return $likes;
        }

        // find likes
        $records = LikeRecord::findAll([
            'userId' => $userId
        ]);

        foreach ($records as $record) {
            $element = Craft::$app->getElements()->getElementById($record->elementId);

            if ($element) {
                // We're interested in the date the like was created, rather than the date
                // the element was created
                $element->dateCreated = DateTimeHelper::toDateTime($record->dateCreated);
                array_push($likes, $element);
            }
        }

        return $likes;
    }

    /**
     * Return a boolean indicating whether the supplied $elementId is a Like
     *
     * @param mixed $elementId
     * @return boolean
     */
    public function isLike($elementId)
    {
        $userId = Craft::$app->getUser()->id;

        if (!$userId) {
            return false;
        }

        $params = [
            'elementId' => $elementId,
            'userId' => $userId,
        ];

        $record = LikeRecord::find()->where($params)->one();

        if ($record) {
            return true;
        }

        return false;
    }

    /**
     * Transfer likes from $userId to $userIdToTransferContentTo
     *
     * @param mixed $userId
     * @param mixed $userIdToTransferContentTo
     * @return boolean
     */
    public function transferLikesByUserId($userId, $userIdToTransferContentTo)
    {
        $records = LikeRecord::findAll([
            'userId' => $userId
        ]);

        foreach ($records as $record) {
            $elementId = $record->elementId;

            // delete original like
            $record->delete();

            // create like on new user
            $this->add($elementId, $userIdToTransferContentTo);
        }

        return true;
    }

    /**
     * Delete Likes from the database matching the supplied $userId
     *
     * @param mixed $userId
     * @return boolean
     */
    public function deleteLikesByUserId($userId)
    {
        $records = LikeRecord::findAll([
            'userId' => $userId
        ]);

        foreach ($records as $record) {
            $like = LikeModel::populateModel($record);

            // delete like
            $record->delete();

            $this->onRemoveLike($like);
        }

        return true;
    }

    /**
     * Trigger an event indicating the addition of a Like
     *
     * @param LikeModel $model
     * @return void
     */
    public function onAddLike(LikeModel $model)
    {
        $event = new LikeEvent([
            'id' => $model->id,
            'userId' => $model->userId,
            'elementId' => $model->elementId,
        ]);

        $this->trigger(self::EVENT_ON_ADD_LIKE, $event);
    }

    /**
     * Trigger an event indicating the removal of a Like
     *
     * @param LikeModel $model
     * @return void
     */
    public function onRemoveLike(LikeModel $model)
    {
        $event = new LikeEvent([
            'id' => $model->id,
            'userId' => $model->userId,
            'elementId' => $model->elementId,
        ]);

        $this->trigger(self::EVENT_ON_REMOVE_LIKE, $event);
    }
}
