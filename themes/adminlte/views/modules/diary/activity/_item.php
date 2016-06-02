<?php
/* @var $model diary\models\Activity */
$f = Yii::$app->formatter;
$this->registerJs("
app.setActivityData({$model->getJsonData()});
");
?>
<li class="activity">
	<i class="fa fa-envelope bg-blue"></i>
	<div class="timeline-item">

		<h3 class="timeline-header">
			<span class="time"><i class="fa fa-clock-o"></i> <?= $model->timelineTime ?></span>

			<div class="pull-right btn-group">
				<span data-toggle="dropdown" class="dropdown-toggle actions" type="button" aria-expanded="false">
					<span class="caret"></span>
				</span>
				<ul class="dropdown-menu">
					<li>
						<a href="#" data-toggle="modal" data-act-id="<?= $model->id ?>"
						   data-target="#act-modal">
							Edit
						</a>
					</li>
					<li>
						<a href="#" data-toggle="modal" data-act-id="<?= $model->id ?>"
						   data-target="#del-modal">Delete</a>
					</li>
				</ul>
			</div>
		</h3>

		<div class="timeline-body">
			<?= $model->timelineNote ?>
		</div>

		
		<?php if ($model->tags || $model->income || $model->outcome): ?>
		<div class="timeline-footer clearfix">
			<?php if ($model->outcome): ?>
			<small class="label label-danger"><?= $f->asPrice($model->outcome) ?></small>
			<?php endif ?>

			<?php if ($model->income): ?>
			<small class="label label-success"><?= $f->asPrice($model->income) ?></small>
			<?php endif ?>
			
			<?php if ($model->tags): ?>
				<div class="pull-right"><?php foreach ($model->tags as $tag): ?>
				<span class="badge bg-purple"><?= $tag->name ?></span>
				<?php endforeach ?></div>
			<?php endif ?>
		</div>
		<?php endif ?>
	</div>
</li>

