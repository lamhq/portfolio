<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
use yii\widgets\ListView;
$this->title = 'What i do';
?>
<h1 class="page-title heading">My Projects</h1>

<?= portfolio\widgets\TagNavigation::widget() ?>

<?php \yii\widgets\Pjax::begin(['timeout' => 10000, 'clientOptions' => ['container' => 'pjax-container']]); ?>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_project',
	'options' => ['class'=>''],
	'layout' => '<div class="portfolios row">{items}</div>{pager}',
	'pager' => [
		'options' => ['class'=>'pag']
	]
]); ?>
<?php \yii\widgets\Pjax::end(); ?>