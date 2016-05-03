<?php
/* @var $this yii\web\View */
/* @var $pagination yii\data\Pagination; */
/* @var $searchModel diary\models\search\ActivitySearch */
/* @var $model diary\models\Activity */
use yii\widgets\LinkPager;

$this->title = 'Timeline';
$this->params['breadcrumbs'][] = $this->title;
$curDate = null;

$newModel = new diary\models\Activity();
$this->registerJs("
MyApp.setActivityData({$newModel->getJsonData()});
MyApp.setupDiaryPage();
");
?>
<div class="activity-index ajax-content">
	<p>
		<button type="button" class="btn btn-success" 
		data-toggle="modal" data-target="#act-modal" data-act-id="0">
			<i class="fa fa-plus"></i>
		</button>
		<button type="button" class="btn btn-primary"
			data-toggle="collapse" data-target="#search">
			<span class="glyphicon glyphicon-search"></span>
		</button>
	</p>
	
	<!-- activity dialog -->
	<?= $this->render('_edit-modal', ['model'=>$model]) ?>
	
	<!-- delete confirm dialog -->
	<?= $this->render('_delete-modal') ?>
	
	<!-- search form -->
	<?php echo $this->render('_search', ['model'=>$searchModel]) ?>
	
	<?php if ($searchModel->models): ?>
	<ul class="timeline">
		<li style="position:absolute; right:0; top: 0; z-index: 90">
		<?= \diary\widgets\IncomeStatistics::widget([
			'query' => $searchModel->query
		]) ?>
		</li>
	<?php foreach($searchModel->models as $model): ?>
		<?php if ($curDate!=$model->timelineDate): ?>
			<?php $curDate = $model->timelineDate ?>
			<li class="time-label">
				<span class="bg-red"><?= $curDate ?></span>
			  </li>
		<?php endif ?>
		<?= $this->render('_item', ['model'=>$model]) ?>
	<?php endforeach ?>
	<li> <i class="fa fa-clock-o bg-gray"></i></li>
	</ul>
	
	<div class="clearfix">
		<?= LinkPager::widget([
			'pagination' => $searchModel->pagination,
			'options' => ['class' => 'pagination pull-right']
		]); ?>
	</div>
	<?php else: ?>
	<p>Sorry, but nothing matched your search.</p>
	<?php endif ?>
</div>