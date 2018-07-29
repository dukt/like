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

namespace dukt\like\base;

use craft\base\Model;

abstract class BaseModel extends Model
{
    // Public Methods
    // =========================================================================

    /**
     * Populates a new model instance with a given set of attributes.
     *
     * @param mixed $values
     * @param bool|null $safeOnly
     *
     * @return Model
     */
    public static function populateModel($values, $safeOnly = true) : Model
    {
        if ($values instanceof Model) {
            $values = $values->getAttributes();
        }

        $class = static::class;

        /** @var Model $model */
        $model = new $class();
        $model->setAttributes($values->getAttributes(), $safeOnly);

        return $model;
    }

    /**
     * Mass-populates models based on an array of attribute arrays.
     *
     * @param array $data
     * @param bool|null $safeOnly
     * @param string|null $indexBy
     *
     * @return array
     */
    public static function populateModels(array $data, $safeOnly = true, $indexBy = null) : array
    {
        $models = [];

        if (\is_array($data)) {
            foreach ($data as $values) {
                $model = static::populateModel($values, $safeOnly);
                if ($indexBy) {
                    $models[$model->$indexBy] = $model;
                } else {
                    $models[] = $model;
                }
            }
        }

        return $models;
    }
}
