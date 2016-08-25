<?php

use yii\widgets\LinkPager;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel note\models\search\PostSearch */

$this->title = 'Notes';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("app.setupBlogPage();");
?>
<div class="post-index ajax-content row">
	<div class="col-md-3 col-md-push-9">
		<?= $this->render('_search', ['model'=>$searchModel]) ?>

		<nav id="post-nav">
		<ul class="list-group nav">
			<?php foreach($searchModel->models as $model): ?>
			<li class="list-group-item"><a class="" href="#post<?= $model->id ?>"><?= $model->title ?></a></li>
			<?php endforeach; ?>
		</ul>
		</nav>
	</div>
	
	<div class="col-md-9 col-md-pull-3">
	<?php if ($searchModel->models): ?>
		<div class="clearfix">
			<?= LinkPager::widget([
				'pagination' => $searchModel->pagination,
				'options' => ['class' => 'pagination pull-left'],
			]); ?>
			<a href="<?= Url::to(['create']) ?>" class="btn btn-success pull-right">Add</a>
		</div>
		<div class="post-list">
			<?php foreach($searchModel->models as $model): ?>
			<?= $this->render('_post', ['model'=>$model]) ?>
			<?php endforeach ?>
		</div>

		<?= LinkPager::widget([
			'pagination' => $searchModel->pagination,
			'options' => ['class' => 'pagination'],
		]); ?>
	<?php else: ?>
		<p>Sorry, but nothing matched your search.</p>
	<?php endif ?>
	</div>
	
</div>