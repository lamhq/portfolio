<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_content')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'content')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'featured_image')->widget(
	 \app\widgets\AjaxUpload::className(), [
		'uploadUrl' => yii\helpers\Url::to(['/site/ajaxUpload']),
		'extensions' => ['jpg', 'jpeg', 'gif', 'png'],
		'maxSize' => 4000,
	]) ?>

    <?= $form->field($model, 'uploadImages')->widget(app\widgets\AjaxUpload::className(), [
		'uploadUrl' => Url::to(['/site/ajaxUpload']),
		'extensions' => ['jpg', 'jpeg', 'gif', 'png'],
		'maxSize' => 4000,
		'multiple' => true,
	]) ?>
	
    <?= $form->field($model, 'status')->dropDownList(app\models\Lookup::items('status'), ['prompt'=>'-- Select --']) ?>

    <?= $form->field($model, 'category_id')->dropDownList(app\models\Category::getListData(), ['prompt'=>'-- Select --']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
