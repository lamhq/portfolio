<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\rating\StarRating;

/* @var $this yii\web\View */
/* @var $model note\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab">General</a></li>
			<li><a href="#tab_2" data-toggle="tab">Advance</a></li>
			<li class="pull-right">
				<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1">
				<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

				<?= $form->field($model, 'content')->widget(kartik\markdown\MarkdownEditor::className()) ?>
			</div><!-- /.tab-pane -->

			<div class="tab-pane" id="tab_2">
				<?php echo $form->field($model, 'rating')->widget(StarRating::classname(), [
					'pluginOptions' => [
						'size' => 'xs',
						'min' => 0,
						'max' => $model::RATING_MAX,
						'step' => 1,
						'showCaption' => true,
					]
				]); ?>
				
				<?php
				$tagNames = array_values($model->getTagListData());
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
			</div><!-- /.tab-pane -->
		</div><!-- /.tab-content -->
	</div><!-- nav-tabs-custom -->
	
    <?php ActiveForm::end(); ?>

</div>
