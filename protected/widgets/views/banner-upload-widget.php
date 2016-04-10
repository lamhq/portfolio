<?php
/* @var $this yii\web\View */
/* @var $options array */
/* @var $items array */
use yii\helpers\Html;
?>
<div id="<?= $options['id'] ?>" class="banner-upload-widget">
	<div class="btn btn-primary btn-file">
		<span class="">Choose file</span>
		<input type="file" class="banner-file-input" <?= $options['multiple'] ? 'multiple' : null ?>/>
	</div>			
	<div class="loader fa fa-spinner fa-spin fa-fw hide"></div>
	
	<ul class="files list-unstyled">
		<?php foreach($items as $k => $data): ?>
		<?php $name = sprintf('%s[%s]', $options['name'], $k) ?>
		<li>
			<img src="<?= $data['url'] ?>" alt="" />
			<p class="name"><?= $data['image'] ?>
			&nbsp;<a class="remove fa fa-trash" href="javascript:void(0)"></a></p>
			<?= Html::hiddenInput("{$name}[id]", $data['id']); ?>
			<?= Html::hiddenInput("{$name}[image]", $data['image']); ?>
		</li>
		<?php endforeach ?>
	</ul>
</div>