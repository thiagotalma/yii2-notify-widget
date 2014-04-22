<?php

/**
 * @copyright Copyright &copy; Thiago Talma, thiagomt.com, 2014
 * @package yii2-notify
 * @version 1.0.0
 */

namespace talma\widgets;

use yii\bootstrap\Alert;
use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Talma Notify widget is a Yii2 wrapper for the Bootstrap Notify.
 *
 * @author Thiago Talma <thiago@thiagomt.com>
 * @since 1.0
 * @see https://github.com/goodybag/bootstrap-notify
 */
class Notify extends Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];

    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    /**
     * @var string Position of the notify bubble
     */
    public $position = 'top-right';

    /**
     * @var string Alert style, omit alert- from style name.
     */
    public $type = 'success';

    /**
     * @var boolean Allow alert to be closable through a close icon.
     */
    public $closable = true;

    /**
     * @var array Alert transition, pretty sure only fade is supported, you can try others if you wish.
     */
    public $transition = 'fade';

    /**
     * @var array Fade alert out after a certain delay (in ms)
     */
    public $fadeOut = [
        'enabled' => true,
        'delay' => 3000
    ];

    /**
     * @var array Text to show on alert, you can use either html or text. HTML will override text.
     */
    public $message = null;

    /**
     * @var string Text to show on alert, you can use either html or text. HTML will override text.
     */
    public $onClose = 'function () {}';

    /**
     * @var string Called before alert closes.
     */
    public $onClosed = 'function () {}';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
        echo Html::tag('div', '', ['id' => 'talmaNotify', 'class' => "notifications {$this->position}"]);

        $session = \Yii::$app->getSession();
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';

        foreach ($flashes as $type => $message) {
            /* initialize css class for each alert box */
            $this->options['class'] = $this->alertTypes[$type] . $appendCss;

            /* assign unique id to each alert box */
            $this->options['id'] = $this->getId() . '-' . $type;

            echo Alert::widget([
                'body' => $message,
                'closeButton' => $this->closeButton,
                'options' => $this->options,
            ]);

            $session->removeFlash($type);
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        NotifyAsset::register($view);

        $config = [
            'type' => $this->type,
            'closable' => $this->closable,
            'transition' => $this->transition,
            'fadeOut' => $this->fadeOut,
            'message' => $this->message,
            'onClose' => new JsExpression($this->onClose),
            'onClosed' => new JsExpression($this->onClosed)
        ];
        $defaults = Json::encode($config);

        $js = <<<SCRIPT
;(function($, window, document, undefined) {
    $('.alert').toNotify({$defaults}, $('#talmaNotify')).show();
})(window.jQuery, window, document);
SCRIPT;
        $view->registerJs($js);
    }
}
