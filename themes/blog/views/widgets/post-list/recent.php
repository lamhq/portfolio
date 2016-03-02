<?php
/* @var $this yii\web\View */
/* @var $posts app\models\Post[] */
?>
<div class="box-1">
	<h3>Recent post</h3>
	<div class="content">
		<ul>
			<?php foreach($posts as $post): ?>
			<li>
				<p class="title"><a href="<?= $post->url ?>"><?= $post->title ?></a></p>
				<p><?= $post->publishedDate ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
