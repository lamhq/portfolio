<?php
/* @var $this yii\web\View */
/* @var $posts app\models\Post[] */
if (!$posts) return;
?>
<h2 class="title-1"><strong>popular reads</strong></h2>
<div class="row">
	<div class="col-md-9">
		<?php foreach($posts as $post): ?>
		<?= $this->render('_post2', ['model'=>$post]) ?>
		<?php endforeach; ?>
	</div>
	<div class="col-md-3">
		<div class="text-center"><a href="#" class="btn-facebook">Follow us on facebook</a></div>
		<div class="facebook-wrap" style="text-align: center;"><img src="<?= $this->theme->baseUrl ?>/img/img-facebook.jpg" alt="" /></div>
		<?=	app\widgets\Banner::widget(['type'=>  app\models\Banner::TYPE_RIGHT]) ?>
	</div>
</div>
