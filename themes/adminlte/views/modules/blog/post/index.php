<?php

use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel blog\models\search\PostSearch */

$this->title = 'Post Listing';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("app.setupBlogPage();");
?>
<div class="post-index ajax-content row">
	<div class="col-md-3 col-md-push-9">
		<?= $this->render('_search', ['model'=>$searchModel]) ?>
		<nav id="post-nav" data-spy="affix" data-offset-top="525" data-offset-bottom="200">
			<div class="list-group nav">
				<?php foreach($searchModel->models as $model): ?>
				<a class="list-group-item" href="#post<?= $model->id ?>"><?= $model->title ?></a>
				<?php endforeach; ?>
			</div>
		</nav>
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