<?php
/* @var $this yii\web\View */
$this->title = 'The Search For The Holy Grail: How I Ended Up With Element Queries, And How You Can Use Them Today';
use yii\helpers\Url;
?>
<article class="post">
	<header class="post-header">
		<h2 class="post-title lined" itemprop="headline"><?= $model->title ?></h2>
	</header>

	<div class="post-meta">
		<p>
			On <time class="post-time" datetime="2014-11-01T01:57:05+00:00" itemprop="datePublished"><?= $model->publishedDate ?></time>.

			<?php if ($model->category): ?>
				<span class="post-categories">In 
				<a rel="category tag" href="<?= $model->category->url ?>"><?= $model->category->name ?></a>.
			<?php endif ?>
		</p>

		<?= \app\widgets\TagList::widget(['query'=>$model->getTags() ]) ?>
	</div>

	<div class="post-content" itemprop="text"><?= $model->content ?></div>
</article>
