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

class LikeController extends BaseController
{
    public function actionAdd(array $variables = array())
    {
        $elementId = craft()->request->getParam('id');

        $userId = craft()->userSession->getUser()->id;

        $response = craft()->like->add($elementId, $userId);

        if (craft()->request->isAjaxRequest()) {

            if ($response) {
                $this->returnJson(array(
                    'success' => true
                ));
            }
            else
            {
                $this->returnErrorJson(Craft::t("Couldn't add like."));
            }
        }
        else
        {
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function actionRemove(array $variables = array())
    {
    	$elementId = craft()->request->getParam('id');
    	$userId = craft()->userSession->getUser()->id;

    	$response = craft()->like->remove($elementId, $userId);

        if (craft()->request->isAjaxRequest()) {

            if ($response) {
                $this->returnJson(array(
                    'success' => true
                ));
            }
            else
            {
                $this->returnErrorJson(Craft::t("Couldn't remove like."));
            }
        }
        else
        {
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
}