<?php
/* @var $this yii\web\View */
/* @var $posts app\models\Post[] */
?>
<div class="relate-wrap">
	<h4>Related</h4>
	<ul>
		<?php foreach($posts as $post): ?>
		<li><a href="<?= $post->url ?>"><?= $post->title ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>