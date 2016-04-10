<?php
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $content string */

\app\assets\OranAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?= $this->render('_head') ?>
<body class="<?= ArrayHelper::getValue($this->params, 'body-class') ?>">
<?php $this->beginBody() ?>
	<?= ArrayHelper::getValue($this->blocks, 'body_begin') ?>
	<div class="page">
		<?= $this->render('_header') ?>
	
		<section id="page-content" role="main">
			<div class="container-fluid">
			<?php if (Yii::$app->session->hasFlash('alert')):?>
				<?php echo \yii\bootstrap\Alert::widget([
					'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
					'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
				])?>
			<?php endif; ?>
			
			<?= $content ?>
			</div><!-- // page-content -->
		</section>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
