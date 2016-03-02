<?php
/* @var $this yii\web\View */
/* @var $banners app\models\Banner[] */
?>
<?php foreach($banners as $banner): ?>
<div class="bn-2"><a href="<?= $banner->link ?>"><img src="<?= $banner->getImageUrl(263, 181) ?>" alt="" /></a></div>
<?php endforeach; ?>
