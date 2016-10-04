<?php
/* @var $models app\models\Category[] */
use yii\helpers\Url;
?>
<section>
	<h3 class="heading">Topics</h3>
	<ul class="link-list">
		<?php foreach ($models as $model): ?>
		<li><a href="<?= $model->url ?>"><?= $model->name ?></a></li>
		<?php endforeach ?>
	</ul>
</section>
