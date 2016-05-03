<?php
namespace app\widgets;
use yii\helpers\Html;
use yii\widgets\InputWidget;

/**
 * Class DatePicker
 * Return boostrap datepicker
 * @package app\widgets
 */
class FlexText extends InputWidget {

	public function run(){
		$model = $this->model;
		$attribute = $this->attribute;
		\app\assets\FlexText::register($this->getView());
		$options = array_merge([
			'id' => Html::getInputId($this->model, $this->attribute),
			'class'=>'form-control'
		], $this->options);
		$id = $options['id'];
		$this->getView()->registerJs("$('#{$id}').flexText();");
		return Html::activeTextarea($model, $attribute, $options);
    }
} 