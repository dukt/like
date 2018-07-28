<?php
/**
 * Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @link      https://github.com/benjamindavid
 * @copyright Copyright (c) 2018 Benjamin David
 */

namespace dukt\like\records;

use dukt\like\Like;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    Benjamin David
 * @package   Like
 * @since     1.0.0
 */
class LikeRecord extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%likes}}';
    }
}
