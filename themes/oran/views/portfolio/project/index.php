<?php
/* @var $dataProvider \yii\data\ActiveDataProvider */
use yii\widgets\ListView;
?>
<h1 class="page-title">Projects</h1>

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