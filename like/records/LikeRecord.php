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

class LikeRecord extends BaseRecord
{
    /**
     * Get Table Name
     */
    public function getTableName()
    {
        return 'likes';
    }

    /**
     * Define Attributes
     */
    public function defineAttributes()
    {
        return array();
    }

    /**
     * @return array
     */
    public function defineIndexes()
    {
        return array(
            array('columns' => array('userId', 'elementId'), 'unique' => true),
        );
    }

    public function defineRelations()
    {
        return array(
            'user' => array(static::BELONGS_TO, 'UserRecord', 'userId', 'required' => true),
            'element' => array(static::BELONGS_TO, 'ElementRecord', 'elementId', 'required' => true)
        );
    }
}