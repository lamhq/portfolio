<?php
/* @var $tags portfolio\models\Tag[] */
/* @var $activeTag string */
/* @var $project int */
use yii\helpers\Url;
?>
<ul class="tags list-inline">
	<?php if (!$project): ?>
	<li class="tag <?= !$activeTag ? 'active' : null ?>"><a href="<?= Url::to(['/portfolio/project']) ?>">All</a></li>
	<?php endif ?>
	<?php foreach ($tags as $tag): ?>
	<li class="tag <?= $tag->slug==$activeTag ? 'active' : null ?>">
		<a href="<?= Url::to(['/portfolio/project', 'tag'=>$tag->slug]) ?>"><?= $tag->name ?></a>
	</li>
	<?php endforeach ?>
</ul>