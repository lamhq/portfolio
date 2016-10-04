<?php
/**
 * @var $this yii\web\View
 */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
$this->registerJs("app.setActiveMenu('blog');", \yii\web\View::POS_READY);
?>
<?php $this->beginContent('@webroot/themes/oran/views/layouts/main.php'); ?>
<h1 class="page-title heading">Blog</h1>
<p class="text-right"><em>Things i learned.</em></p>

<div class="row">
	<main class="content col-md-9">
		<?= $content ?>
	</main>
	<div class="sidebar col-md-3">
		<?= app\widgets\CategoryList::widget(); ?>
		<?= app\widgets\PostList::widget([
			'type'=>app\widgets\PostList::TYPE_RECENT
		]); ?>

		<section>
			<h3 class="heading">Tags</h3>
			<?= \app\widgets\TagList::widget([ 'query'=>app\models\Tag::find() ]) ?>
		</section>

		<section class="search-form">
			<h3 class="heading">Search</h3>

			<form action="<?= Url::to(['/blog/search']) ?>" method="GET">
				<div class="input-group">
					<?= Html::textInput('s', ArrayHelper::getValue($_GET, 's'), 
						['class'=>'form-control', 'placeholder'=>'Enter keyword...']) ?>
					<span class="input-group-btn"> <button type="submit" class="btn btn-port">Go!</button> </span>
				</div>
			</form>
		</section>
	</div>
</div>

<?php $this->endContent(); ?>