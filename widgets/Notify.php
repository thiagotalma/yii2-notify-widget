<?php

/**
 * @copyright Copyright &copy; Thiago Talma, thiagomt.com, 2014
 * @package yii2-notify
 * @version 1.0.0
 */

namespace talma\widgets;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Talma Notify widget is a Yii2 wrapper for the Bootstrap Notify.
 *
 * @author Thiago Talma <thiago@thiagomt.com>
 * @since 1.0
 * @see https://github.com/goodybag/bootstrap-notify
 */
class Notify extends \yii\widgets\InputWidget
{
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		$this->registerAssets();

		echo Html::activeTextInput($this->model, $this->attribute, ['class' => 'hidden', 'value' => $this->value]);

		$this->options['id'] = 'notify_' . $this->options['id'];
		Html::addCssClass($this->options, "notify_{$this->attribute}");
		echo Html::tag('div', '', $this->options);
	}

	/**
	 * Registers the needed assets
	 */
	public function registerAssets()
	{
		$view = $this->getView();
		NotifyAsset::register($view);

		$config = [
			'core' => array_merge(['data' => $this->data], $this->core),
			'checkbox' => $this->checkbox,
			'contextmenu' => $this->contextmenu,
			'dnd' => $this->dnd,
			'search' => $this->search,
			'sort' => $this->sort,
			'state' => $this->state,
			'plugins' => $this->plugins,
			'types' => $this->types
		];
		$defaults = Json::encode($config);

		$inputId = Html::getInputId($this->model, $this->attribute);

		$js = <<<SCRIPT
;(function($, window, document, undefined) {
	$('#notify_{$this->options['id']}')
		.notify({$defaults});
})(window.jQuery, window, document);
SCRIPT;
		$view->registerJs($js);
	}

}