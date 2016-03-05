<?php
/* @var $this app\widgets\AjaxUpload */
/* @var $options array */
/* @var $attribute string */
/* @var $model yii\base\Model */
use yii\helpers\Html;
$attribute = preg_replace('/^\[.+\]/', '', $attribute);
$value = $model->$attribute;
?>
<div id="<?= $options['id'] ?>" class="ajax-upload-widget">
	<div class="btn btn-primary btn-file">
		<span class="">Choose file</span>
		<input type="file" class="ajax-file-input" <?= $options['multiple'] ? 'multiple' : null ?>/>
	</div>			
	<div class="loader fa fa-spinner fa-spin fa-fw hide"></div>
	
	<ul class="files list-unstyled">
	<?php if ($options['multiple']): // multi upload ?>
		<?php foreach($value as $k => $file): ?>
		<?php $name = sprintf('%s[%s]', $options['name'], $k) ?>
		<li>
			<?= $file ?>
			&nbsp;<a class="remove fa fa-remove" href="javascript:void(0)"></a>
			<?= Html::hiddenInput($name, $file); ?>
		</li>
		<?php endforeach ?>
	<?php else: // single upload ?>
		<?php if ($value): ?>
		<li>
			<?= $value ?>
			&nbsp;<a class="remove fa fa-remove" href="javascript:void(0)"></a>
			<?= Html::activeHiddenInput($model, $attribute); ?>
		</li>
		<?php endif ?>
	<?php endif ?>
	</ul>
</div>