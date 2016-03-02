<?php
use yii\helpers\ArrayHelper;

/* @var $this \yii\web\View */
/* @var $content string */

\app\assets\BlogAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?= $this->render('_head') ?>
<body class="<?= ArrayHelper::getValue($this->params, 'body-class') ?>">
<?php $this->beginBody() ?>
	<div class="page">
		<?= $this->render('_header') ?>
	
		<div class="container main">
			<?php if (Yii::$app->session->hasFlash('alert')):?>
				<?php echo \yii\bootstrap\Alert::widget([
					'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
					'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
				])?>
			<?php endif; ?>
			
			<?= $content ?>
			
			<?= app\widgets\SubscribeForm::widget() ?>
			<?=	app\widgets\Banner::widget(['type'=>  app\models\Banner::TYPE_BOTTOM]) ?>
		</div><!-- // main -->
		<?= $this->render('_footer') ?>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
