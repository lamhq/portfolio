<?php

use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model todo\models\Plan */
$compl = $model->completedCount;
$total = $model->totalCount ?: 1;
$perc = $compl * 100 / $total;
?>
<div class="box plan" data-plan-id="<?= $model->id ?>">
	<div class="box-header with-border">
		<i class="fa fa-tasks"></i>
		<h3 class="box-title">
			<a href="<?= Url::to(['view', 'id'=>$model->id]) ?>"><?= $model->name ?></a>
		</h3>

		<div class="box-tools pull-right">
			<span class="stat"><?= $compl ?>/<?= $total ?></span>
			<span data-toggle="dropdown" class="dropdown-toggle actions" type="button" aria-expanded="false">
				<span class="caret"></span>
			</span>
			<ul class="dropdown-menu">
				<li>
					<a href="#" class="edit-plan">Edit</a>
				</li>
				<li>
					<a href="<?= Url::to(['delete', 'id'=>$model->id]) ?>"
					   data-method="post" data-confirm="Are you sure you want to delete &quot;<?= $model->name ?>&quot;?">
						Delete
					</a>
				</li>
				<li>
					<a data-confirm="Are you sure to archive &quot;<?= $model->name ?>&quot;?" 
					   data-method="post" href="<?= Url::to(['archive', 'id'=>$model->id]) ?>">
						Archive
					</a>
				</li>
			</ul>
		</div>
	</div><!-- box-header -->

	<div class="box-body"><?= $model->description ?></div>
	<div class="box-footer">
		<div class="progress progress-sm active">
			<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
				 aria-valuenow="<?= $perc ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $perc ?>%">
				<span class="sr-only"><?= $perc ?>% Complete</span>
			</div>
		</div>
	</div>
</div>