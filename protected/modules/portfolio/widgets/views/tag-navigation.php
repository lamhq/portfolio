<?php
/* @var $tags portfolio\models\Tag[] */
/* @var $activeId int */
use yii\helpers\Url;
?>
<ul class="tags list-inline">
	<li class="tag <?= !$activeId ? 'active' : null ?>"><a href="<?= Url::to(['/portfolio/project']) ?>">All</a></li>
	<?php foreach ($tags as $tag): ?>
	<li class="tag <?= $tag->id==$activeId ? 'active' : null ?>">
		<a href="<?= Url::to(['/portfolio/project/tag', 'name'=>$tag->name]) ?>"><?= $tag->name ?></a>
	</li>
	<?php endforeach ?>
</ul>