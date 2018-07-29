<?php

/**
 * Craft Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2015, Dukt
 * @link      https://dukt.net/craft/like/
 * @license   https://dukt.net/craft/like/docs/license
 */
namespace dukt\like\models;

use dukt\like\Like;
use dukt\like\base\BaseModel;
use Craft;

class LikeModel extends BaseModel
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $userId;

    /**
     * @var string
     */
    public $elementId;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'elementId'], 'string'],
        ];
    }

    public function getUser()
    {
        if ($this->userId) {
            return Craft::$app->getUsers()->getUserById($this->userId);
        }
    }

    public function getElement()
    {
        if ($this->elementId) {
            return Craft::$app->getElements()->getElementById($this->elementId);
        }
    }
}
