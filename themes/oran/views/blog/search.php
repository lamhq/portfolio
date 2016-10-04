<?php
/* @var $this yii\web\View */
use yii\widgets\ListView;
use yii\helpers\Url;
use yii\helpers\Html;
$this->title = sprintf('Search Results for "%s"', $term);
?>
<section class="latest-posts">
	<h2 class="heading lined">Search Results for: <?= Html::encode($term) ?></h2>
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
