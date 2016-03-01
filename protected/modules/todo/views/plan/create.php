<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model todo\models\Plan */

$this->title = 'Create Plan';
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="plan-create">

	<div class="box">
		<div class="box-body">
		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
		</div>
	</div>
	
</div>
