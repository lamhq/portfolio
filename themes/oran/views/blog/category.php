<?php
/* @var $this yii\web\View */
use yii\widgets\ListView;
use yii\helpers\Url;
?>
<section class="latest-posts">
	<h2 class="heading lined"><?= $model->name ?></h2>
	<?= ListView::widget([
	    'dataProvider' => $dataProvider,
	    'itemView' => '_post',
		'options' => ['class'=>''],
		'layout' => '<div class="post-list">{items}</div>{pager}',
		'pager' => [
			'options' => ['class'=>'pag']
		]
	]); ?>
</section>