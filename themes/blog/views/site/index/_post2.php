<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */
?>
<div class="intro clearfix">
	<figure><a href="<?= $model->url ?>" class="imgeffect"><img src="<?= $model->getImageUrl(236, 177) ?>" alt="" /></a></figure>
	<div class="descript">
		<?php if ($model->category): ?>
		<p class="ico-trend"><?= $model->category->name ?></p>
		<?php endif ?>
		<h3><a href="<?= $model->url ?>"><?= $model->title ?></a></h3>
		<p class="date">By <a href="#"><?= $model->author->username ?> on <a href="#"><?= $model->publishedDate ?></a></p>
		<p><?= $model->short_content ?></p>
	</div>
</div>
