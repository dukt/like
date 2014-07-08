<?php

namespace Craft;

class Like_LikeElementType extends BaseElementType
{
    /**
     * Returns the element type name.
     *
     * @return string
     */
    public function getName()
    {
        return Craft::t('Like');
    }

    public function populateElementModel($row)
    {
        return Like_LikeModel::populateModel($row);
    }

    public function modifyElementsQuery(DbCommand $query, ElementCriteriaModel $criteria)
    {
        $query
            ->addSelect('like.likeElementId, like.userId')
            ->join('like like', 'like.id = elements.id');
    }
}
