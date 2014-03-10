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


    /**
     * Modifies an element query that's filtering by this field.
     *
     * @param DbCommand $query
     * @param mixed     $value
     * @return null|false
     */
    public function modifyElementsQuery(DbCommand $query, $value)
    {
        var_dump($value);
        $handle = $this->model->handle;

        // $query
        //     ->addSelect('entries.sectionId, entries.typeId, entries.authorId, entries.root, entries.lft, entries.rgt, entries.depth, entries.postDate, entries.expiryDate, entries_i18n.slug')
        //     ->join('entries entries', 'entries.id = elements.id')
        //     ->join('entries_i18n entries_i18n', 'entries_i18n.entryId = elements.id')
        //     ->andWhere(array('or', 'entries.lft IS NULL', 'entries.lft != 1'))
        //     ->andWhere('entries_i18n.locale = elements_i18n.locale');
        $query->join('likes likes', 'likes.id = elements.id');
        $query->count('likes.id as '.'content.'.craft()->content->fieldColumnPrefix.$handle);
        // $query->andWhere(DbHelper::parseParam('content.'.craft()->content->fieldColumnPrefix.$handle, $value, $query->params));
    }
}
