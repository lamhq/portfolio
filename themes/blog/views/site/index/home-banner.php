<?php
/* @var $this yii\web\View */
/* @var $posts app\models\Post[] */
use app\components\Helper;
app\assets\HomeBannerAsset::register($this);
?>
<!-- home banner -->
<ul class="slider slider id-slider autoplay-0 interval-5000 pause_on_hover-1">
	<?php foreach($posts as $post): ?>
	<li class="slide bg">
		<?= Helper::holderImage($post->getImageUrl(1148,373), 1148,373, [
			'class'=>'attachment-slider-thumb size-slider-thumb wp-post-image bgimg',
			'title'=> $post->title,
			'alt'=> $post->title,
		]) ?>
		<div class="slider_content_box">
			<ul class="post_details">
				<?php if ($post->category): ?>
				<li class="category">
					<a class="category-68" href="<?= $post->category->url ?>"><?= $post->category->name ?></a>
				</li>
				<?php endif ?>
				<li class="date"><?= $post->publishedDate ?></li>
			</ul>
			<h2><a href="<?= $post->url ?>"><?= $post->title ?></a></h2>
			<p class="clearfix"></p>
		</div>
	</li>
	<?php endforeach; ?>
</ul>
<div class="slider_posts_list_container"></div>