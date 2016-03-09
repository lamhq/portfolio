<?php
/* @var $this yii\web\View */
/* @var $posts app\models\Post[] */
if (!$posts) return;
?>
<h2 class="title-1"><strong>popular reads</strong></h2>

<?php foreach($posts as $post): ?>
<?= $this->render('_post2', ['model'=>$post]) ?>
<?php endforeach; ?>
