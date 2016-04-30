<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model portfolio\models\Project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'reference')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'short_content')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'uploadImages')->widget(\app\widgets\BannerUpload::className(), [
		'uploadUrl' => Url::to(['/site/ajaxUpload']),
		'extensions' => ['jpg', 'jpeg', 'gif', 'png'],
		'maxSize' => 4000,
		'multiple' => true,
	]) ?>
	
	<?php
	$tagNames = array_values(\app\models\Tag::getListData());
	?>
	<?= $form->field($model, 'tagValues')->widget(
		Select2::className(), [
		'data' => array_combine($tagNames, $tagNames),
		'options' => [
//			'placeholder'=>'Enter tags',
		],
		'pluginOptions' => [
			'multiple' => true,
			'tags' => true,
			'tokenSeparators' => [','],
		],
	]) ?>
	
    <?= $form->field($model, 'status')->dropDownList(app\models\Lookup::items('status'), ['prompt'=>'-- Select --']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
