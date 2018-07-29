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

namespace dukt\like\events;

use dukt\like\Like;

use yii\base\Event;


class LikeEvent extends Event
{
    // Public Properties
    // =========================================================================

    /**
     * @var int|null ID
     */
    public $id;

    /**
     * @var int|null User ID
     */
    public $userId;

    /**
     * @var int|null ID
     */
    public $elementId;

}
