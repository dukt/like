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

class LikeController extends BaseController
{
    public function actionAdd(array $variables = array())
    {
    	$elementId = craft()->request->getParam('id');
    	$userId = craft()->userSession->getUser()->id;

    	craft()->like->add($elementId, $userId);

    	$this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionRemove(array $variables = array())
    {
    	$elementId = craft()->request->getParam('id');
    	$userId = craft()->userSession->getUser()->id;

    	craft()->like->remove($elementId, $userId);

    	$this->redirect($_SERVER['HTTP_REFERER']);
    }
}