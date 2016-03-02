<?php
/* @var $this yii\web\View */
/* @var $posts app\models\Post[] */
if (!$posts) return;
?>
<h2 class="title-1"><strong>popular reads</strong></h2>
<div class="row">
	<div class="col-md-9">
		<?php foreach($posts as $post): ?>
		<div class="intro clearfix">
			<figure><a href="<?= $post->url ?>" class="imgeffect"><img src="<?= $post->getImageUrl(236, 177) ?>" alt="" /></a></figure>
			<div class="descript">
				<?php if ($post->category): ?>
				<p class="ico-trend"><?= $post->category->name ?></p>
				<?php endif ?>
				<h3><a href="<?= $post->url ?>"><?= $post->title ?></a></h3>
				<p class="date">By <a href="#"><?= $post->author->username ?> on <a href="#"><?= $post->publishedDate ?></a></p>
				<p><?= $post->short_content ?></p>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<div class="col-md-3">
		<div class="text-center"><a href="#" class="btn-facebook">Follow us on facebook</a></div>
		<div class="facebook-wrap" style="text-align: center;"><img src="<?= $this->theme->baseUrl ?>/img/img-facebook.jpg" alt="" /></div>
		<?=	app\widgets\Banner::widget(['type'=>  app\models\Banner::TYPE_RIGHT]) ?>
	</div>
</div>
