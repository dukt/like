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

class Like_CountFieldType extends BaseFieldType
{
    /**
     * Block type name
     */
    public function getName()
    {
        return Craft::t('Like Count');
    }

    /**
     * Show field
     */
    public function getInputHtml($name, $value)
    {
        $likes = craft()->like->getLikes($this->element->id);

        return craft()->templates->render('like/countField', array(
            'element' => $this->element,
            'totalLikes' => count($likes)
        ));
    }


    public function prepValue($value)
    {
        $likes = craft()->like->getLikes($this->element->id);

        return count($likes);
    }

    /**
     * Modifies an element query
     *
     * @param DbCommand $query
     * @param mixed     $value
     * @return null|false
     */
    public function modifyElementsQuery(DbCommand $query, $value)
    {
        $handle = $this->model->handle;

        $query->addSelect('count(likes.id) AS '.craft()->content->fieldColumnPrefix.$handle);
        $query->leftJoin('likes likes', 'likes.elementId = elements.id');
    }
}
