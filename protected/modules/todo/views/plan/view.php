<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model todo\models\form\PlanForm */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

\app\assets\Nestable::register($this);
$this->registerJs("setupPlanPage()");
?>

<div class="plan-view">
	<div class="box">
		<div class="box-body">
			
			<div class="clearfix">
				<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
				<?= Html::a('Delete', ['delete', 'id' => $model->id], [
					'class' => 'btn btn-danger',
					'data' => [
						'confirm' => 'Are you sure you want to delete this item?',
						'method' => 'post',
					],
				]) ?>
				<div class="pull-right">
					<p>
					<button type="button" class="btn btn-info btn-add">Add</button>
					<button type="button" class="btn btn-default btn-tog-comp">Hide completed</button>
					<button type="submit" class="btn btn-primary btn-submit">Save</button>
					</p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-4">
					<h2><?= $model->name ?></h2>
					<div class="desc"><?= $model->description ?></div>
				</div>
				<div class="col-md-8">
				<?php $form = ActiveForm::begin(); ?>
					<?= yii\helpers\Html::activeHiddenInput($model, 'hierarchyJson') ?>
					
					
					<?php $this->beginBlock('before_body_end') ?>
					<ul class="task-tpl hide">
						<?= $this->render('_task', [
							'model' => $model, 
							'item' => ['id'=>'new'], 
						]) ?>
					</ul>
					<?php $this->endBlock() ?>					
					
					
					<div id="tasks" class="dd nestable todos">
						<ol class="dd-list">
							<?php foreach($model->hierarchy as $item) :?>
								<?= $this->render('_task', [
									'model' => $model, 
									'item' => $item, 
								]) ?>
							<?php endforeach; ?>
						</ol>
					</div>
				<?php ActiveForm::end(); ?>
				</div>
			</div>
			
		</div>
	</div>
</div>
