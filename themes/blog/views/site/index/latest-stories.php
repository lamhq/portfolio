<?php
/* @var $this yii\web\View */
/* @var $posts app\models\Post[] */
if (!$posts) return;
$first = $posts[0];
$second = $posts[1];
?>
<h2 class="title-1"><strong>latest stories</strong></h2>
<div class="row">
	<div class="col-md-9">
		<div class="row intro-wrap">
			<div class="col-md-8 intro">
				<?= $this->render('_post', ['model'=>$first, 'mode'=>'big']) ?>
			</div>
			<div class="col-md-4">
				<?= $this->render('_post', ['model'=>$second, 'mode'=>'small' ]) ?>
			</div>
		</div>
		<div class="row">
			<?php for($idx=2; $idx<count($posts); $idx++): ?>
			<div class="col-md-4">
				<?= $this->render('_post', ['model'=>$posts[$idx], 'mode'=>'small' ]) ?>
			</div>
			<?php endfor ?>
		</div>
	</div>
	<div class="col-md-3">
		<div class="text-center"><a href="https://www.facebook.com/sgonehomeproperty" class="btn-facebook">Follow us on facebook</a></div>
		<?= app\widgets\FacebookPage::widget() ?>
		<?=	'';//app\widgets\Banner::widget(['type'=>  app\models\Banner::TYPE_RIGHT]) ?>
	</div>
</div>
