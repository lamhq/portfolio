<?php
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

\app\assets\AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<?= $this->render('_head') ?>
</head>
<body class="skin-blue sidebar-collapse sidebar-mini <?= ArrayHelper::getValue($this->params, 'body-class') ?>">
<?php $this->beginBody() ?>
<div class="wrapper">
	<?= $this->render('_header') ?>
	
	<?php echo $this->render('_sidebar') ?>
		
	<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?= $this->title ?>
				<?php if(isset($this->params['subtitle'])): ?>
					<small><?= $this->params['subtitle'] ?></small>
				<?php endif; ?>
			</h1>

			<?= Breadcrumbs::widget([
				'tag'=>'ol',
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]) ?>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php if (Yii::$app->session->hasFlash('alert')):?>
				<?php echo \yii\bootstrap\Alert::widget([
					'body'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
					'options'=>ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
				])?>
			<?php endif; ?>
			<?= $content ?>
		</section><!-- /.content -->
	</aside><!-- /.right-side -->
	
</div>
<?= $this->blocks['before_body_end'] ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
