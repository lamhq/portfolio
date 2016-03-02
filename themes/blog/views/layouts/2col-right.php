<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\widgets\Breadcrumbs;
?>
<?php $this->beginContent('@webroot/themes/blog/views/layouts/main.php'); ?>

<div class="row">
	<div class="col-md-9">
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>
			
		<?= $content ?>
	</div>
	<div class="col-md-3">
		<?php if (isset($this->blocks['sidebar'])): ?>
			<?= $this->blocks['sidebar'] ?>
		<?php endif; ?>
		<?=	app\widgets\Banner::widget(['type'=>  app\models\Banner::TYPE_RIGHT]) ?>
	</div>
</div>

<?php $this->endContent(); ?>