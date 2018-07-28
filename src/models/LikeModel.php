<?php
/**
 * Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @link      https://github.com/benjamindavid
 * @copyright Copyright (c) 2018 Benjamin David
 */

namespace dukt\like\models;

use dukt\like\Like;

use Craft;
use craft\base\Model;

/**
 * @author    Benjamin David
 * @package   Like
 * @since     1.0.0
 */
class LikeModel extends Model
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
