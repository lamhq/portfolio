<?php
/* @var $this yii\web\View */
/* @var $model diary\models\search\ActivitySearch */
/* @var $form yii\widgets\ActiveForm */

use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use diary\models\search\ActivitySearch;
use kartik\datetime\DateTimePicker;
use diary\models\Tag;

$this->registerJs(
"$('#btnReset').click(function() {
	$('#search .form-group input').val('');
	$('#search').submit();
});
");
?>
<?php $form = ActiveForm::begin([
	'options'=>['id'=>'search', 'class'=>'collapse']
]); ?>
	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($model, 'key')->label(false)->textInput(['placeHolder'=>'Key word']) ?>
		</div>
		<div class="col-sm-6">
			<?= $form->field($model, 'searchTags')->label(false)->widget(
				Select2::className(), [
				'data' => Tag::getTagListData(),
				'options' => [
					'placeholder'=>'Tags',
				],
				'pluginOptions' => [
					'multiple' => true,
				],			
			]) ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'dateRange')->label(false)
			->dropdownList(ActivitySearch::$DATE_RANGE_LIST, ['class'=>'form-control date-range']) ?>
		</div>
		
		<div class="col-md-3 from-date">
			<?= $form->field($model, 'fromDate')->label(false)->widget(
				DateTimePicker::className(),[
					'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
					'pluginOptions' => [
						'format' => \app\components\Helper::getBootstrapDatepickerFormat(),
						'autoclose'=>true,
						'todayHighlight'=>true,
						'minView'=>2,	// month view only
					],
					'options'=>['placeHolder'=>'From']
				]
			) ?>
		</div>
			
		<div class="col-md-3 to-date">
			<?= $form->field($model, 'toDate')->label(false)->widget(
				DateTimePicker::className(),[
					'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
					'pluginOptions' => [
						'format' => \app\components\Helper::getBootstrapDatepickerFormat(),
						'autoclose'=>true,
						'todayHighlight'=>true,
						'minView'=>2,	// month view only
					],
					'options'=>['placeHolder'=>'To']
				]
			) ?>
		</div>
	</div>

	<div class="form-group">
		<button type="button" class="btn btn-default" id="btnReset">Reset</button>
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
<?php ActiveForm::end(); ?>