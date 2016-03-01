<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel blog\models\search\PostSearch */

$this->title = 'Post Listing';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("MyApp.setupBlogPage();");
?>
<div class="post-index ajax-content row">
	<div class="col-md-3 col-md-push-9">
		<?= $this->render('_search', ['model'=>$searchModel]) ?>
	</div>
	
	<div class="col-md-9 col-md-pull-3">
	<?php if ($searchModel->models): ?>
		<?= LinkPager::widget([
			'pagination' => $searchModel->pagination,
			'options' => ['class' => 'pagination'],
		]); ?>

		<?php foreach($searchModel->models as $model): ?>
		<?= $this->render('_post', ['model'=>$model]) ?>
		<?php endforeach ?>

		<?= LinkPager::widget([
			'pagination' => $searchModel->pagination,
			'options' => ['class' => 'pagination'],
		]); ?>
	<?php else: ?>
		<p>Sorry, but nothing matched your search.</p>
	<?php endif ?>
	</div>
	
</div>