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

namespace dukt\like;

use dukt\like\services\LikeService;
use dukt\like\variables\LikeVariable;
use dukt\like\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\elements\User;
use craft\base\Element;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Like
 *
 * @author    Benjamin David
 * @package   Like
 * @since     1.0.0
 *
 * @property  LikeService $likeService
 */
class Like extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Like
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->setComponents([
            'likeService' => LikeService::class,
        ]);

        // Event::on(
        //     UrlManager::class,
        //     UrlManager::EVENT_REGISTER_SITE_URL_RULES,
        //     function (RegisterUrlRulesEvent $event) {
        //         $event->rules['siteActionTrigger1'] = 'like/default';
        //     }
        // );

        // Event::on(
        //     UrlManager::class,
        //     UrlManager::EVENT_REGISTER_CP_URL_RULES,
        //     function (RegisterUrlRulesEvent $event) {
        //         $event->rules['cpActionTrigger1'] = 'like/default/do-something';
        //     }
        // );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('like', LikeVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Event::on(
            User::class,
            User::EVENT_BEFORE_DELETE,
            function (Event $event) {
                $user = $event->sender;
                $userId = $user->id;
                $userIdToTransferContentTo = $event->transferContentTo;

                if ($userIdToTransferContentTo) {
                    LikeService::transferLikesByUserId($userId, $userIdToTransferContentTo);
                } else {
                    LikeService::deleteLikesByUserId($userId);
                }
            }
        );

        Event::on(
            Element::class,
            Element::EVENT_BEFORE_DELETE_ELEMENT,
            function (Event $event) {
                $element = $event->element;
                $likes = LikeService::getLikesByElementId($element->id);

                foreach ($likes as $like) {
                    LikeService::deleteLikeById($like->id);
                }
            }
        );

        Craft::info(
            Craft::t(
                'like',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        $likes = LikeService::getLikes();

        return Craft::$app->view->renderTemplate('like/table', [
            'label' => Craft::t('Pages that have been liked'),
            'instructions' => Craft::t('All columns are sortable by clicking the column heading'),
            'id' => 'likes',
            'name' => 'likes',
            'cols' => array(
                'title' => array('heading' => Craft::t('Page title'), 'type' => 'multiline'),
                'uri' => array('heading' => Craft::t('URL'), 'type' => 'singleline', 'width' => '50%'),
                'count' => array('heading' => Craft::t('Likes'), 'type' => 'singleline', 'width' => '10%'),
            ),
            'rows' => $likes
        ]);
    }
}
