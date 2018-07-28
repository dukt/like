<?php
/**
 * Like plugin for Craft CMS 3.x
 *
 * A simple plugin to connect to Like's API.
 *
 * @link      https://github.com/benjamindavid
 * @copyright Copyright (c) 2018 Benjamin David
 */

namespace dukt\like\controllers;

use dukt\like\Like;

use Craft;
use craft\web\Controller;

/**
 * @author    Benjamin David
 * @package   Like
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    // protected $allowAnonymous = ['index', 'add', 'remove'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionAdd(array $variables = array())
    {
        $request = Craft::$app->getRequest();

        $elementId = $request->getParam('id');
        $userId = Craft::$app->getUser()->id;

        $response = Like::$plugin->likeService->add($elementId, $userId);

        if ($request->getIsAjax()) {
            if ($response) {
                return $this->asJson([
                    'success' => true,
                ]);
            } else {
                return $this->returnErrorJson(Craft::t("Couldn't add like."));
            }
        } else {
            return $this->redirect($request->getReferrer());
        }
    }

    public function actionRemove(array $variables = array())
    {
        $request = Craft::$app->getRequest();

        $elementId = $request->getParam('id');
        $userId = Craft::$app->getUser()->id;

        $response = Like::$plugin->likeService->remove($elementId, $userId);

        if ($request->getIsAjax()) {
            if ($response) {
                return $this->asJson([
                    'success' => true,
                ]);
            } else {
                return $this->returnErrorJson(Craft::t("Couldn't remove like."));
            }
        } else {
            return $this->redirect($request->getReferrer());
        }
    }
}
