<?php
/* @var $this yii\web\View */
/* @var $post app\models\Post */
use \app\widgets\PostList;
$this->params['breadcrumbs'][] = $post->title;
$this->title = $post->title;
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
		<li class="glyphicon glyphicon-user">By <a href="#"><?= $post->author->username ?></a> on <?= $post->publishedDate ?></li>
	</ul>
	<div style="margin: 10px 0;">
		<?=	\app\widgets\AddThis::widget(['url'=>$post->url,'title'=>$post->title]) ?>
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
