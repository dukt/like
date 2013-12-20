<?php

/**
 * Craft Like by Dukt
 *
 * @package   Craft Like
 * @author    Benjamin David
 * @copyright Copyright (c) 2013, Dukt
 * @link      http://dukt.net/craft/like/
 * @license   http://dukt.net/craft/like/docs/license
 */

namespace Craft;

class LikeVariable
{
    public function isLike($elementId)
    {
        return craft()->like->isLike($elementId);
    }

    public function getLikes($elementType = null)
    {
    	return craft()->like->getLikes($elementType);
    }
}
