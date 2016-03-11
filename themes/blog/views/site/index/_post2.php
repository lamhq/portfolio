<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */
use app\components\Helper;

?>
<div class="intro clearfix">
	<figure>
		<a href="<?= $model->url ?>" class="imgeffect">
			<?= Helper::holderImage($model->getImageUrl(236, 177), 236, 177) ?>
		</a>
	</figure>
	<div class="descript">
		<?php if ($model->category): ?>
		<p class="ico-trend"><?= $model->category->name ?></p>
		<?php endif ?>
		<h3><a href="<?= $model->url ?>"><?= $model->title ?></a></h3>
		<p><?= $model->short_content ?></p>
	</div>
</div>
