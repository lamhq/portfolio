<?php
/* @var $model blog\models\Post */
use yii\helpers\Url;
\yii\web\YiiAsset::register($this);
?>
<div class="box box-solid">
	<div class="box-header with-border clearfix">
		<h3 class="box-title"><?= $model->title ?></h3>
		<div class="pull-right">
			<a href="<?= Url::to(['update', 'id'=>$model->id]) ?>">
				<i class="fa fa-edit"></i>
			</a>
			<a href="<?= Url::to(['delete', 'id'=>$model->id]) ?>"
			   data-method="post" data-confirm="Are you sure you want to delete this item?">
				<i class="fa fa-trash"></i>
			</a>
		</div>
		<div class="post-rating pull-right">
			<?php for($i=0; $i<$model->rating; $i++): ?>
			<i class="glyphicon glyphicon-star"></i>
			<?php endfor ?>
			<?php for($i=0; $i<$model::RATING_MAX-$model->rating; $i++): ?>
			<i class="glyphicon glyphicon-star-empty"></i>
			<?php endfor ?>
		</div>
	</div><!-- /.box-header -->
	<div class="box-body post-content">
		<?= $model->formattedContent ?>
	</div><!-- /.box-body -->
	<div class="box-footer">
		<?php foreach ($model->tags as $tag): ?>
		<span class="badge bg-purple"><?= $tag->name ?></span>
		<?php endforeach ?>
	</div>
</div>
