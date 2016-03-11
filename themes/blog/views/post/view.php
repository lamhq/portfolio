<?php
/* @var $this yii\web\View */
/* @var $post app\models\Post */
use \app\widgets\PostList;
if ($post->category) {
	$c = $post->category;
	$this->params['breadcrumbs'][] = ['label' => $c->name, 'url' => $c->url];
}
$this->params['breadcrumbs'][] = $post->title;
$this->title = $post->title;

// register metatag for facebook share
$this->registerMetaTag(['property'=>'og:image', 'content'=>$post->getImageUrl() ]);
$info = getimagesize($post->generateImagePath());
if ($info) {
	$this->registerMetaTag(['property'=>'og:image:width', 'content'=>$info[0] ]);
	$this->registerMetaTag(['property'=>'og:image:height', 'content'=>$info[1] ]);
}

$this->registerMetaTag(['property'=>'og:title', 'content'=>$post->title ]);
$this->registerMetaTag(['property'=>'og:url', 'content'=>$post->url ]);
$this->registerMetaTag(['property'=>'og:description', 'content'=> strip_tags($post->short_content) ]);
?>
<div class="document">
	<h1><?= $post->title ?></h1>
	
	<!-- post images -->
	<?= $this->render('@webroot/themes/blog/views/widgets/banner/slider', ['banners'=>$post->images]) ?>

	<ul class="quick-info clearfix">
		<!--
		<li class="glyphicon glyphicon-star"><a href="#">Celebrity real estate</a></li>
		<li class="glyphicon glyphicon-picture">Gallery</li>
		-->
	</ul>
	<div style="margin: 10px 0;">
		<?=	\app\widgets\FacebookShareButton::widget(['url'=>$post->url]) ?>
	</div>
	<?= $post->content ?>
</div>

<!-- related post -->
<?= PostList::widget([
	'type'=>  PostList::TYPE_RELATED,
	'posts'=>$post->getRelatedPosts()
]) ?>

<!-- comments -->
<?= '';//$this->render('_comments', ['post'=>$post]) ?>
	
<?php $this->beginBlock('sidebar'); ?>
<?= PostList::widget([
	'posts' => \app\models\Post::getLatestPosts(),
	'type' => PostList::TYPE_RECENT
]) ?>
<?php $this->endBlock(); ?>
