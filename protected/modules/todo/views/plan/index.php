<?php

use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models todo\models\Plan[] */
/* @var $updateModel todo\models\Plan */
/* @var $grid array */

$this->title = 'Plans';
$this->params['breadcrumbs'][] = $this->title;

\yii\web\YiiAsset::register($this);
\yii\jui\JuiAsset::register($this);
$gridUpdateUrl = Url::to(['grid-update']);
$this->registerJs("setupPlanGrid('$gridUpdateUrl')");
?>
<div class="plan-index">
	<p>
		<a href="<?= Url::to(['create']) ?>" class="btn btn-success">
			Create Plan
		</a>
    </p>

	<!-- update form -->
	<?= $this->render('_update-modal', ['model' => $updateModel]) ?>
	
	<div class="row">
		<?php foreach($grid as $idx => $col): ?>
		<div class="col-md-4 connectedSortable" data-col-id="<?= $idx ?>">
			<?php foreach($col as $planId): ?>
			<?php if ( !isset($models[$planId]) ) continue ?>
			<?php $model = $models[$planId]; ?>
				<?= $this->render('_plan', ['model'=>$model]) ?>
			<?php endforeach ?>
		</div>
		<?php endforeach ?>
	</div>
</div>
