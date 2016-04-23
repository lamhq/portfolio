<?php
/* @var $model portfolio\models\Project */
?>
<div class="col-md-4 col-sm-6">
	<article class="img-wrapper portfolio">
		<a href="<?= $model->url ?>">
			<div class="wrapper">
				<header><h2><?= $model->title ?></h2></header>
				<div class="content"><?= $model->short_content ?></div>
			</div>
			<?= app\components\Helper::holderImage($model->getFeaturedImage(280,280), 280,280) ?>
		</a>
	</article>
</div>