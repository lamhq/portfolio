<?php
/* @var $this yii\web\View */
/* @var $model diary\models\Activity */
/* @var $form yii\widgets\ActiveForm */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use diary\models\Tag;
?>
<?php $form = ActiveForm::begin([
	'action'=>$model->isNewRecord ? ['save'] : ['save', 'id'=>$model->id],
	'enableAjaxValidation' => true,
]); ?>
	<?= Html::activeHiddenInput($model, 'month') ?>
	<?= Html::activeHiddenInput($model, 'year') ?>

	<div class="row">
		<div class="col-sm-6">
			<?= $form->field($model, 'tag_id')->widget(
				Select2::className(), [
				'data' => Tag::getTagListData(),
			]) ?>
		</div>
		<div class="col-sm-6">
			<?= $form->field($model, 'budget')->textInput([
				'class'=>'form-control', 
			]) ?>
		</div>
	</div>

	<div class="form-group clearfix">
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-primary pull-right btn-submit"
		 data-loading-text="Processing...">Save</button>
	</div>
<?php ActiveForm::end(); ?>
<?php
$this->registerJs("app.setupBudgetForm();");	// run after activeform js
?>