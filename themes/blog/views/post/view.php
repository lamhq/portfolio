<?php
/* @var $this yii\web\View */
/* @var $post app\models\Post */
use \app\widgets\PostList;
$this->params['breadcrumbs'][] = $post->title;
$this->title = $post->title;
?>
<div class="document">
	<h1><?= $post->title ?></h1>
	<div class="bnslider">
		<div class="item"><img src="img/bn-2.jpg" alt="" /></div>
		<div class="item"><img src="img/bn-2.jpg" alt="" /></div>
		<div class="item"><img src="img/bn-2.jpg" alt="" /></div>
		<div class="item"><img src="img/bn-2.jpg" alt="" /></div>
	</div>
	<ul class="quick-info clearfix">
		<li class="glyphicon glyphicon-star"><a href="#">Celebrity real estate</a></li>
		<li class="glyphicon glyphicon-picture">Gallery</li>
		<li class="glyphicon glyphicon-user">By <a href="#"><?= $post->author->username ?></a> on <?= $post->publishedDate ?></li>
	</ul>
	<div style="margin: 10px 0;"><img src="<?= $this->theme->baseUrl ?>/img/share.png" alt="" /></div>
	<?= $post->content ?>
</div>
<?= PostList::widget([
	'type'=>  PostList::TYPE_RELATED,
	'posts'=>$post->getRelatedPosts()
]) ?>
<ul class="nav nav-tabs">
	<li class="active"><a href="#comment" data-toggle="tab">1 comment</a></li>
	<li><a href="#blog" data-toggle="tab">Zillow Blog</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="comment">
		<div class="comment-row clearfix">
			<figure><img src="img/img-user.jpg" alt="" /></figure>
			<div class="descript">
				<div class="input-group">
					<input type="text" class="form-control" />
					<span class="input-group-addon"><button class="btn">Post as ZanZan</button></span>
				</div>
			</div>
		</div>
		<div class="comment-row clearfix">
			<figure><img src="img/img-user.jpg" alt="" /></figure>
			<div class="descript">
				<div class="name"><a href="#"><strong>Zan Zan</strong></a> <span>|</span> 6 hours ago</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut</p>
				<p>Labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
				<ul class="action clearfix">
					<li><a href="#" class="glyphicon glyphicon-menu-up">Up</a> <span>|</span> <a href="#" class="glyphicon glyphicon-menu-down">Down</a></li>
					<li><a href="#">Edit</a></li>
					<li><a href="#">Reply</a></li>
					<li><a href="#">Share</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="tab-pane" id="blog">
		Content...
	</div>
</div>
	
<?php $this->beginBlock('sidebar'); ?>
<?= PostList::widget([
	'posts' => \app\models\Post::getLatestPosts(),
	'type' => PostList::TYPE_RECENT
]) ?>
<?php $this->endBlock(); ?>
