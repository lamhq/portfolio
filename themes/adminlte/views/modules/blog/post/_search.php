<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model blog\models\search\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-search search-form">

    <?php $form = ActiveForm::begin(['action'=>['index']]); ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'minRating')->dropDownList(array_combine(range(1,5),range(1,5)), ['prompt'=>'All']) ?>

    <?= $form->field($model, 'searchTags')->widget(
		Select2::className(), [
		'data' => blog\models\Tag::getListData(),
		'options' => [
			'placeholder'=>'Tags',
		],
		'pluginOptions' => [
			'multiple' => true,
		],			
	]) ?>

    <?= $form->field($model, 'sort')->dropDownList($model::$SORT_BY) ?>
    
	<?= $form->field($model, 'dir')->dropDownList($model::$DIRECTIONS) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <button type="button" class="btnReset btn btn-default">Reset</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
