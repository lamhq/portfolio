<?php
/**
 * @var $this yii\web\View
 */
use app\models\Post;
use yii\helpers\Url;
?>
<header id="page-header">
	<p id="logo"><a href="<?= Yii::$app->homeUrl ?>">
		<img src="<?= $this->theme->baseUrl ?>/img/logo.jpg" alt="<?= Yii::$app->name ?>">
	</a></p>
	<p class="tagline">Web Developer</p>

	<nav class="navbar navbar-default">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
	</nav>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="clearfix" id="main-nav">
			<li><a href="<?= Url::to(['/portfolio/project']) ?>">Projects</a></li>
			<li><a href="<?= Post::getUrlBySlug('about') ?>">About</a></li>
			<li><a href="<?= Url::to(['/site/contact']) ?>">Contact</a></li>
		</ul>

		<div class="social-links">
			<ul class="list-inline">
				<li class="facebook">
					<a href="https://www.facebook.com/daibanglam" title="Friend us on Facebook">
						<i class="fa fa-2x fa-facebook"></i>
					</a>
				</li>
				<li class="twitter">
					<a href="https://twitter.com/mrsecon" title="Follow us on Twitter">
						<i class="fa fa-2x fa-twitter"></i>
					</a>
				</li>
				<!--
				<li class="youtube">
					<a href="https://www.youtube.com/channel/UC1KQcSFdCXo-gPxUtOQlGOw" title="Watch us on Youtube">
						<i class="fa fa-2x fa-youtube"></i>
					</a>
				</li>
				-->
				<li class="linkedin">
					<a href="https://www.linkedin.com/pub/lam-huynh/102/179/52a" title="Link us on LinkedIn">
						<i class="fa fa-2x fa-linkedin"></i>
					</a>
				</li>
			</ul>
		</div>					
	</div>
	<!-- /.navbar-collapse -->
</header>
