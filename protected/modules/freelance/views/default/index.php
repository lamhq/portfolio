<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model freelance\models\Project */

$this->title = 'Analyze project jsonBids';
$this->params['breadcrumbs'][] = $this->title;
$dataProvider = new ArrayDataProvider([
    'allModels' => $model->bids,
    'sort' => [
        'attributes' => ['name', 'rate', 'price', 'period'],
    ],
    'pagination' => [
        'pageSize' => 100,
    ],
])
?>
<div class="daufault-index">

	<div class="box">
		<div class="box-body">
			
		<?php $form = ActiveForm::begin(); ?>
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li>
					<a data-toggle="tab" href="#tab_1" aria-expanded="false">Input</a>
				</li>
				<li class="active">
					<a data-toggle="tab" href="#tab_2" aria-expanded="false">Result</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="tab_1" class="tab-pane">
					<p>Copy and paste these code to browser</p>
					<div class="clearfix">
						<?= $this->render('js') ?>
					</div>

					<p>Then paste the json text from browser to this textbox</p>
					<?= $form->field($model, 'jsonBids')->textArea()->label(false) ?>
					<p><button type="submit" class="btn btn-default">Analyze</button></p>
				</div>
				<!-- /.tab-pane -->
				<div id="tab_2" class="tab-pane active">
					<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
							'dateRange',
							'priceRange',
							'rateRange',
							'avgRate',
						],
					]) ?>
					
					<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'columns' => [
							'name',
							'rate',
							'price',
							'period',
						],
					]) ?>
				</div>
				<!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
		</div>
		<?php ActiveForm::end(); ?>

		</div>
	</div>
</div>
