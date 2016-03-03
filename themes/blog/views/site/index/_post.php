<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $mode string */
$imgUrl = $mode=='big' ? $model->getImageUrl(553, 302) : $model->getImageUrl(261, 142);
?>
<a href="<?= $model->url ?>" class="imgeffect"><img src="<?= $imgUrl ?>" alt="" /></a>
<?php if ($model->category): ?>
<p class="ico-trend"><?= $model->category->name ?></p>
<?php endif ?>
<h3><a href="<?= $model->url ?>"><?= $model->title ?></a></h3>
<p class="date">By <a href="#"><?= $model->author->username ?></a> on <a href="#"><?= $model->publishedDate ?></a></p>
<p><?= $model->short_content ?></p>
<p><a href="<?= $model->url ?>" class="btn-1">read more</a></p>
