<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\AceEditor;

/* @var $this yii\web\View */
/* @var $model todo\models\Plan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="plan-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#tab_1" aria-expanded="false">Tasks</a>
			</li>
			<li>
				<a data-toggle="tab" href="#tab_2" aria-expanded="false">General</a>
			</li>
			<li class="pull-right">
				<?= Html::submitButton($model->isNewRecord ?
					'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</li>
		</ul>
		<div class="tab-content">
			<div id="tab_1" class="tab-pane active">
				<?php echo $form->field($model, 'taskString')->label(false)->widget(
					AceEditor::className(), ['mode' => 'php']
				) ?>
			</div>
			<!-- /.tab-pane -->
			<div id="tab_2" class="tab-pane">
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

				<?php echo $form->field($model, 'description')->widget(
					\yii\imperavi\Widget::className(),
					[
						'plugins' => ['fullscreen'],
						'options' => [
							'minHeight' => 400,
							'maxHeight' => 400,
							'buttonSource' => true,
							'convertDivs' => false,
							'removeEmptyTags' => true,
						]
					]
				) ?>
			</div>
			<!-- /.tab-pane -->
		</div>
		<!-- /.tab-content -->
	</div>
    <?php ActiveForm::end(); ?>

</div>
