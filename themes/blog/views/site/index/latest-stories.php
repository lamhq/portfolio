<?php
/* @var $this yii\web\View */
/* @var $posts app\models\Post[] */
if (!$posts) return;
$first = $posts[0];
?>
<h2 class="title-1"><strong>latest stories</strong></h2>
<div class="row intro-wrap">
	<div class="col-md-6 intro">
		<?= $this->render('_post', ['model'=>$first, 'mode'=>'big']) ?>
	</div>
	<div class="col-md-6">
	<?php for($idx=1; $idx<count($posts); $idx++): ?>
		<?php if ( ($idx-1)%2 == 0 ): ?><div class="row"><?php endif ?>
		<div class="col-xs-6 intro">
			<?= $this->render('_post', ['model'=>$posts[$idx], 'mode'=>'small' ]) ?>
		</div>
		<?php if ( ($idx-1)%2 == 1 || $idx==count($posts)-1 ): ?></div><?php endif ?>
	<?php endfor ?>
	</div>
</div>
