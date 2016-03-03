<?php
/**
 * @var $this yii\web\View
 * @var $text string
 */
use yii\helpers\Url;
use yii\helpers\Html;
?>
<form method="get" action="<?= Url::to(['site/search']) ?>">
	<div class="input-group quick-search">
		<input type="text" name="s" value="<?= Html::encode($text) ?>" class="form-control" placeholder="Search" />
		<span class="input-group-btn"><button class="btn-search" type="submit">Search</button></span>
	</div>
</form>
