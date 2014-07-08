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
            array('columns' => array('userId', 'likeElementId'), 'unique' => true),
        );
    }

    public function defineRelations()
    {
        return array(
            'element'   => array(static::BELONGS_TO, 'ElementRecord', 'id', 'required' => true, 'onDelete' => static::CASCADE),
            'user' => array(static::BELONGS_TO, 'UserRecord', 'userId', 'required' => true, 'onDelete' => static::CASCADE),
            'likeElement' => array(static::BELONGS_TO, 'ElementRecord', 'likeElementId', 'required' => true, 'onDelete' => static::CASCADE)
        );
    }
}