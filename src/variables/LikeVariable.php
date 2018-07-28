<?php
/**
 * Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @link      https://github.com/benjamindavid
 * @copyright Copyright (c) 2018 Benjamin David
 */

namespace dukt\like\variables;

use dukt\like\Like;

use Craft;

/**
 * @author    Benjamin David
 * @package   Like
 * @since     1.0.0
 */
class LikeVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param string $elementId
     * @return bool
     */
     public function isLike($elementId)
    {
        return Like::$plugin->likeService->isLike($elementId);
    }

    /**
     * @param string $elementId (optional)
     * @return array
     */
    public function getLikes($elementId = null)
    {
        return Like::$plugin->likeService->getLikes($elementId);
    }

    /**
     * @param string $elementType (optional)
     * @param string $userId (optional)
     * @return array
     */
    public function getUserLikes($elementType = null, $userId = null)
    {
        return Like::$plugin->likeService->getUserLikes($elementType, $userId);
    }
}
