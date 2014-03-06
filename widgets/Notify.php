<?php

/**
 * @copyright Copyright &copy; Thiago Talma, thiagomt.com, 2014
 * @package yii2-notify
 * @version 1.0.0
 */

namespace talma\widgets;
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
class Notify extends \yii\bootstrap\Widget
{
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