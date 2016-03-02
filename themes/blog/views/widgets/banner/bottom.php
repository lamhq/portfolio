<?php
/* @var $this yii\web\View */
/* @var $banners app\models\Banner[] */
?>
<?php foreach($banners as $banner): ?>
<div class="bn-1">
	<a href="<?= $banner->link ?>"><img src="<?= $banner->getImageUrl(728, 90) ?>" alt="" /></a>
</div>
<?php endforeach; ?>
