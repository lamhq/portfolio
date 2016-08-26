<?php
/* @var $tags portfolio\models\Tag[] */
/* @var $activeTag string */
/* @var $project int */
use yii\helpers\Url;
?>
<p class="tags">
	<?php if (!$project): ?>
	<a href="<?= Url::to(['/portfolio/project']) ?>" class="tag <?= !$activeTag ? 'active' : null ?>" >All</a>
	<?php endif ?>
	<?php foreach ($tags as $tag): ?>
	<a href="<?= Url::to(['/portfolio/project', 'tag'=>$tag->slug]) ?>" 
		class="tag <?= $tag->slug==$activeTag ? 'active' : null ?>"><?= $tag->name ?></a>
	<?php endforeach ?>
</p>