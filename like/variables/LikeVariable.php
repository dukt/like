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

class LikeVariable
{
    public function isLike($elementId)
    {
        return craft()->like->isLike($elementId);
    }

    public function getLikes($elementId = null)
    {
    	return craft()->like->getLikes($elementId);
    }

    public function getUserLikes($elementType = null, $userId = null)
    {
        return craft()->like->getUserLikes($elementType, $userId);
    }
}
