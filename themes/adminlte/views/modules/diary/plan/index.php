<?php
use yii\helpers\Html;
use diary\models\Plan;
use yii\helpers\Url;
$this->title = 'Outcome Plan';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("app.setupOutcomePage();");
?>
<form action="<?=  Url::to(['index']) ?>" method="get" id="filter-form">
	<div class="form-inline">
		<div class="form-group">
			<?= Html::dropDownList('m', $month, Plan::getMonthList(), ['class'=>'month-sel form-control']) ?>
			<?= Html::dropDownList('y', $year, Plan::getYearList(), ['class'=>'year-sel form-control']) ?>
			<button class="btn btn-success btn-add" type="button">Add Budget</button>
		</div>
	</div>
</form>
<br/>

<div class="box box-solid">
	<div class="box-body">
		<?php foreach ($items as $item): ?>
		<div class="row">
			<div class="col-md-3 col-xs-6 clearfix">
				<div class="pull-left">
					<a href="#" data-id="<?= $item->id ?>" class="btn-edit"><?= $item->tag->name ?></a>
					<a aria-hidden="true" class="glyphicon glyphicon-remove btn-delete" href="<?= Url::to(['delete', 'id'=>$item->id ]) ?>"></a>
				</div>
				<div class="pull-right"><?= number_format($item->outcome) ?> / <?= number_format($item->budget) ?></div>
			</div>
			<div class="col-md-9 col-xs-12">
				<div class="progress">
					<?php $percent = min(100, $item->outcome*100/$item->budget) ?>
					<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="<?= $percent ?>" 
						aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent ?>%;">
						<span class="sr-only"><?= $percent ?>% Complete</span>
					</div>
				</div>
			</div>
		</div>
		<?php endforeach ?>
	</div>
</div>

<div class="modal" id="budget-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Add new Budget</h4>
			</div>

			<div class="modal-body"></div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="hide not-used"><?= $this->render('_form', ['model'=> new Plan() ]) ?></div>
