<?php
/* @var $this yii\web\View */
/* @var $category app\models\Category */
/* @var $dataProvider \yii\data\ActiveDataProvider */
use app\widgets\PostList;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = $category->name;
$this->title = $category->name;
?>
<div class="document">
	<h1><?= Html::encode($category->name) ?></h1>
	
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '@webroot/themes/blog/views/site/index/_post2',
	]); ?>
</div>

	
<?php $this->beginBlock('sidebar'); ?>
<?= PostList::widget([
	'posts' => \app\models\Post::getLatestPosts(),
	'type' => PostList::TYPE_RECENT
]) ?>
<?php $this->endBlock(); ?>
