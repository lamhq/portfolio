<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $mode string */
use app\components\Helper;
?>
<a href="<?= $model->url ?>" class="imgeffect">
	<?php if ($mode=='big'): ?>
		<?= Helper::holderImage($model->getImageUrl(553, 302), 553, 302) ?>
	<?php else: ?>
		<?= Helper::holderImage($model->getImageUrl(261, 142), 261, 142) ?>
	<?php endif ?>
</a>
<?php if ($model->category): ?>
<p class="ico-trend"><?= $model->category->name ?></p>
<?php endif ?>
<h3><a href="<?= $model->url ?>"><?= $model->title ?></a></h3>
<p class="date">By <a href="#"><?= $model->author->username ?></a> on <a href="#"><?= $model->publishedDate ?></a></p>
<p><?= $model->short_content ?></p>
<p><a href="<?= $model->url ?>" class="btn-1">read more</a></p>
