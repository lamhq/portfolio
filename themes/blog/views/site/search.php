<?php
/* @var $this yii\web\View */
/* @var $search string */
/* @var $dataProvider \yii\data\ActiveDataProvider */
use app\widgets\PostList;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->params['breadcrumbs'][] = 'Search result';
$this->title = sprintf('Result of "%s"', $search);
?>
<div class="document">
	<h1>Result of "<?= Html::encode($search) ?>"</h1>
	
	<?php if ($search): ?>
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'itemView' => '@webroot/themes/blog/views/site/index/_post2',
	]); ?>
	<?php else: ?>
	<p><em>Sorry! Your search term is invalid</em></p>
	<?php endif ?>
</div>

	
<?php $this->beginBlock('sidebar'); ?>
<?= PostList::widget([
	'posts' => \app\models\Post::getLatestPosts(),
	'type' => PostList::TYPE_RECENT
]) ?>
<?php $this->endBlock(); ?>
