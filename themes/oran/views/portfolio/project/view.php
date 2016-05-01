<?php
/* @var $this yii\web\View */
/* @var $model \portfolio\models\Project */
$images = [];
\omnilight\assets\FancyBoxAsset::register($this);
$this->registerJs("
	$('.fancybox').fancybox({
        padding : 0,
        fitToView: false,
        maxWidth: '90%'
    });
", yii\web\View::POS_END);
?>
<article class="portfolio-single">
	<div class="row">
		<div class="col-md-6 col-md-push-6">
			<header>
				<h1><?= $model->title ?></h1>
				<?= portfolio\widgets\TagNavigation::widget(['project'=>$model->id]) ?>
			</header>
			<div class="desc"><?= $model->content ?></div>
			<?php if ($model->reference): ?>
			<p style="margin-top: 10px"><a href="<?= $model->reference ?>" class="btn btn-port" target="_blank">View website</a></p>
			<?php endif ?>
		</div>
		<div class="col-md-6 col-md-pull-6">
			<?php $carouselId = 'carousel-'.time() ?>
			<!-- Carousel -->
			<div id="<?php echo $carouselId ?>" class="carousel slide medium" data-ride="carousel" data-interval="false">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<?php foreach($model->images as $k => $image): ?>
					<li data-target="#<?php echo $carouselId ?>" data-slide-to="<?= $k ?>"
						class=" <?php echo $k==0 ? 'active' : '' ?>"></li>
					<?php endforeach ?>
				</ol>

				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<?php foreach($model->images as $k => $image): ?>
					<div class="item <?php echo $k==0 ? 'active' : '' ?>">
						<a class="fancybox" rel="group" href="<?= $image->getImageUrl() ?>">
							<img src="<?= $image->getImageUrl(600) ?>" alt=""/>
						</a>
					</div>
					<?php endforeach ?>
				</div>

				<!-- Controls -->
				<a class="left carousel-control" href="#<?php echo $carouselId ?>" role="button" data-slide="prev">
					<span class="fa fa-2x fa-arrow-circle-left glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#<?php echo $carouselId ?>" role="button" data-slide="next">
					<span class="fa fa-2x fa-arrow-circle-right glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</article>

