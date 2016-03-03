<?php
/* @var $this yii\web\View */
/* @var $post app\models\Post */
?>
<ul class="nav nav-tabs">
	<li class="active"><a href="#comment" data-toggle="tab"><?= count($post->comments) ?> comment</a></li>
	<li><a href="#blog" data-toggle="tab">Zillow Blog</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="comment">
		<?php if (!Yii::$app->user->isGuest): ?>
		<div class="comment-row clearfix">
			<figure><img src="img/img-user.jpg" alt="" /></figure>
			<div class="descript">
				<div class="input-group">
					<input type="text" class="form-control" />
					<span class="input-group-addon"><button class="btn">Post as ZanZan</button></span>
				</div>
			</div>
		</div>
		<?php endif ?>
		<?php foreach($post->comments as $comment): ?>
		<?= $this->render('_comment', ['comment'=>$comment]) ?>
		<?php endforeach ?>
	</div>
	<div class="tab-pane" id="blog">
		Content...
	</div>
</div>