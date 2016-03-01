<?php
/* @var $income int */
/* @var $outcome int */
/* @var $profit int */
$css = $profit > 0 ? 'success' : 'danger';
$f = Yii::$app->formatter;
?>

<a tabindex="0" class="btn btn-<?= $css ?>" role="button"
   data-toggle="popover" data-trigger="focus" title="Income / Outcome" data-placement="left"
   data-content="<?= $f->asPrice($income) ?> / <?= $f->asPrice($outcome) ?>">
	<?= $f->asPrice($profit) ?></a>
