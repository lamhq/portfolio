<?php
/* @var $this yii\web\View */
$this->title = 'Homepage';
?>
<?= $this->render('index/home-banner', ['posts'=>\app\models\FeaturedPost::getPosts()]) ?>
<?= $this->render('index/latest-stories', ['posts'=>  \app\models\Post::getLatestPosts()]) ?>
<?= $this->render('index/popular-read', ['posts'=>  \app\models\Post::getMostViewedPosts()]) ?>
