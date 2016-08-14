<?php
/* @var $this yii\web\View */
/* @var $model diary\models\Activity */
/* @var $form yii\widgets\ActiveForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;
use app\widgets\FlexText;
use diary\models\Tag;
?>
<?php $form = ActiveForm::begin([
	'enableClientValidation' => true,
	'validateOnSubmit'       => true,
]); ?>
	<?= Html::activeHiddenInput($model, 'id') ?>

	<?= $form->field($model, 'note')->label(false)->widget(
		FlexText::className(), [
			'options'=>[
				'placeHolder'=>'Your note',
			]
		]
	) ?>

	<?= $form->field($model, 'inputTime')->label(false)->widget(
		DateTimePicker::className(),[
			'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
			'pluginOptions' => [
				'format' => 'dd/mm/yyyy hh:ii',
				'autoclose'=>true,
				'todayHighlight'=>true,
				'minuteStep'=>15,
			]
		]
	) ?>

	<?php
	$tagNames = array_values(Tag::getTagListData());
	?>
    <?= $form->field($model, 'tagValues')->label(false)->widget(
		Select2::className(), [
		'data' => array_combine($tagNames, $tagNames),
		'options' => [
			'placeholder'=>'Enter tags',
		],
		'pluginOptions' => [
			'multiple' => true,
			'tags' => true,
			'tokenSeparators' => [','],
		],			
	]) ?>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'income')->label(false)->textInput([
				'class'=>'form-control', 
				'placeHolder'=>'In-come',
			]) ?>

		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'outcome')->label(false)->textInput([
				'class'=>'form-control', 
				'placeHolder'=>'Out-come',
			]) ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary pull-right">Save</button>
	</div>
<?php ActiveForm::end(); ?>