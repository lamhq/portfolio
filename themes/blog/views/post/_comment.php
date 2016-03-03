<?php
/* @var $this yii\web\View */
/* @var $comment app\models\Comment */
$author = $comment->author;
?>
<div class="comment-row clearfix">
	<?php if ($author): ?>
	<figure><img src="<?= $author->getImageUrl(50,50) ?>" alt="" /></figure>
	<?php endif ?>
	<div class="descript">
		<?php if ($author): ?>
		<div class="name"><a href="#"><strong><?= $author->username ?></strong></a> <span>|</span> 6 hours ago</div>
		<?php endif ?>
		<?= $comment->content ?>
		<?php if ($author && Yii::$app->user->id==$author->id): ?>
		<ul class="action clearfix">
			<li><a href="#" class="glyphicon glyphicon-menu-up">Up</a> <span>|</span> <a href="#" class="glyphicon glyphicon-menu-down">Down</a></li>
			<li><a href="#">Edit</a></li>
			<li><a href="#">Reply</a></li>
			<li><a href="#">Share</a></li>
		</ul>
		<?php endif ?>
	</div>
</div>
