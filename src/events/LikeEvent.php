<?php
/**
 * Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @link      https://github.com/benjamindavid
 * @copyright Copyright (c) 2018 Benjamin David
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
