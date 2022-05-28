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

namespace dukt\like\controllers;

use dukt\like\Like;

use Craft;
use craft\web\Controller;

class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected array|int|bool $allowAnonymous = ['index', 'add', 'remove'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionAdd($elementId)
    {
        $request = Craft::$app->getRequest();

        $userId = Craft::$app->getUser()->id;

        $response = Like::$plugin->likeService->add($elementId, $userId);

        if ($request->getIsAjax()) {
            if ($response) {
                return $this->asJson([
                    'success' => true,
                ]);
            } else {
                return $this->returnErrorJson(Craft::t('like', "Couldn't add like."));
            }
        } else {
            return $this->redirect($request->getReferrer());
        }
    }

    public function actionRemove($elementId)
    {
        $request = Craft::$app->getRequest();

        $userId = Craft::$app->getUser()->id;

        $response = Like::$plugin->likeService->remove($elementId, $userId);

        if ($request->getIsAjax()) {
            if ($response) {
                return $this->asJson([
                    'success' => true,
                ]);
            } else {
                return $this->returnErrorJson(Craft::t('like', "Couldn't remove like."));
            }
        } else {
            return $this->redirect($request->getReferrer());
        }
    }
}
