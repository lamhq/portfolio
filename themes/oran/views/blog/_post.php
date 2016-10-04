<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */
use yii\helpers\Url;
use app\components\Helper;
?>
<article class="post">
	<div class="row">
		<div class="col-md-4">
			<p>
				<a href="<?= $model->url ?>"><?= Helper::holderImage($model->getImageUrl(420, 315), 420, 315) ?></a>
			</p>
			<div class="post-meta">
				<?= \app\widgets\TagList::widget(['query'=>$model->getTags() ]) ?>
			</div>
		</div>
		<div class="col-md-8">
			<header class="post-header">
				<h3 class="post-title" itemprop="headline"><a href="<?= $model->url ?>"><?= $model->title ?></a></h3>
			</header>

			<div class="post-content" itemprop="text">
				<?= $model->short_content ?>
			</div>

			<footer class="post-footer">
				<div class="post-meta">
				<p>
					On <time class="post-time" datetime="2014-11-01T01:57:05+00:00" itemprop="datePublished"><?= $model->publishedDate ?></time>.
					<?php if ($model->category): ?>
						<span class="post-categories">In 
						<a rel="category tag" href="<?= $model->category->url ?>"><?= $model->category->name ?></a>.
					<?php endif ?>
				</p>
				</div>
			</footer>
		</div>
	</div>
</article>
