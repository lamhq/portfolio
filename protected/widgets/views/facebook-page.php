<?php

/**
 * @var $this yii\web\View
 * @var $text string
 */
?>
<div class="fb-page" data-href="https://www.facebook.com/sgonehomeproperty" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
	<div class="fb-xfbml-parse-ignore">
		<blockquote cite="https://www.facebook.com/sgonehomeproperty">
			<a href="https://www.facebook.com/sgonehomeproperty">OneHome Property Pte Ltd</a>
		</blockquote>
	</div>
</div>
	
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