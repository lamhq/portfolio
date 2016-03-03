<?php
/* @var $this yii\web\View */
/* @var $banners app\models\Banner[] */
?>
<div class="bnslider">
	<?php foreach($banners as $banner): ?>
	<div class="item"><img src="<?= $banner->getImageUrl(900,450) ?>" alt="" /></div>
	<?php endforeach ?>
</div>
