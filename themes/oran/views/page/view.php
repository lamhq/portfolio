<?php
/* @var $this yii\web\View */
/* @var $post app\models\Post */
$this->title = $post->title;
?>

<article id="post-<?= $post->id ?>" class="page type-page status-publish hentry">
		<?= $post->content ?>
</article><!-- #post-## -->


