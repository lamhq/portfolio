<?php
/* @var $this yii\web\View */
/* @var $model app\models\Post */
$this->title = $model->title;
?>
<h1 class="page-title heading"><?= $model->title ?></h1>

<article id="post-<?= $model->id ?>" class="page type-page">
	<?= $model->content ?>
</article><!-- #post-## -->


