<?php
/* @var $tags app\models\Tag[] */
use yii\helpers\Url;
?>
<p class="post-tags tags">
	<?php foreach ($tags as $tag): ?>
	<a class="tag" href="<?= $tag->url ?>"><?= $tag->name ?></a>
	<?php endforeach ?>
</p>
