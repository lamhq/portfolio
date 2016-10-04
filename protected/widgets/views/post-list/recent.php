<?php
/* @var $tags app\models\Tag[] */
use yii\helpers\Url;
?>
<section>
	<h3 class="heading">Latest Posts</h3>
	<ul class="link-list">
		<?php foreach ($models as $model): ?>
		<li><a href="<?= $model->url ?>"><?= $model->title ?></a></li>
		<?php endforeach ?>
	</ul>
</section>
