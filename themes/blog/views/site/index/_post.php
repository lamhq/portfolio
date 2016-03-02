<?php
/* @var $this yii\web\View */
/* @var $post app\models\Post */
/* @var $mode string */
$imgUrl = $mode=='big' ? $post->getImageUrl(553, 302) : $post->getImageUrl(261, 142);
?>
<a href="<?= $post->url ?>" class="imgeffect"><img src="<?= $imgUrl ?>" alt="" /></a>
<?php if ($post->category): ?>
<p class="ico-trend"><?= $post->category->name ?></p>
<?php endif ?>
<h3><a href="<?= $post->url ?>"><?= $post->title ?></a></h3>
<p class="date">By <a href="#"><?= $post->author->username ?></a> on <a href="#"><?= $post->publishedDate ?></a></p>
<p><?= $post->short_content ?></p>
<p><a href="<?= $post->url ?>" class="btn-1">read more</a></p>
