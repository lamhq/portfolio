<?php
/* @var $this yii\web\View */
/* @var $options array */
/* @var $items array */
use yii\helpers\Html;
\yii\jui\JuiAsset::register($this);
?>
<div id="<?= $options['id'] ?>" class="banner-upload-widget">
	<div class="btn btn-primary btn-file">
		<span class="">Choose file</span>
		<input type="file" class="banner-file-input" <?= $options['multiple'] ? 'multiple' : null ?>/>
	</div>
	
	<div class="loader fa fa-spinner fa-spin fa-fw hide"></div>
	
	<div class="files row">
		<?php foreach($items as $k => $data): ?>
		<?php $name = sprintf('%s[%s]', $options['name'], $k) ?>
		<div class="item col-md-3"><div class="inn">
			<img src="<?= $data['url'] ?>" alt="" class="img-responsive" />
			<p class="name"><?= $data['image'] ?>
			&nbsp;<a class="remove fa fa-trash" href="javascript:void(0)"></a></p>
			<?= Html::hiddenInput("{$name}[id]", $data['id']); ?>
			<?= Html::hiddenInput("{$name}[image]", $data['image']); ?>
		</div></div>
		<?php endforeach ?>
	</div>
</div>