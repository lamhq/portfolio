<?php

/**
 * @var $this yii\web\View
 * @var $url string
 */
use yii\helpers\Html;
?>
<div class="fb-share-button" data-href="<?= Html::encode($url) ?>" data-layout="button_count"></div>
	
<?php $this->beginBlock('body_begin') ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1660171227592894";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php $this->endBlock() ?>
