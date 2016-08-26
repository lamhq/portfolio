<?php
/**
 * @var $this yii\web\View
 */
use app\models\Post;
use yii\helpers\Url;
?>
<header id="page-header">
	<p id="logo" class="text-center img-wrapper">
		<a href="<?= Yii::$app->homeUrl ?>">
			<img src="<?= $this->theme->baseUrl ?>/img/logo.jpg" alt="<?= Yii::$app->name ?>" class="img-responsive"/>
		</a>
	</p>
	<p class="tagline text-center">Lam Huynh</p>

	<button type="button" class="btn-nav" data-toggle="collapse" data-target="#left-navbar" aria-expanded="false">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

	<div id="left-navbar" class="collapse">
		<nav id="main-nav">
			<ul>
				<li><a href="<?= Url::to(['/blog']) ?>">Blog</a></li>
				<li><a href="<?= Url::to(['/portfolio/project']) ?>">What i do</a></li>
				<li><a href="<?= Post::getUrlBySlug('about') ?>">About me</a></li>
				<li><a href="<?= Url::to(['/site/contact']) ?>">Contact</a></li>
			</ul>
		</nav>

		<!-- <div class="social-links">
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
				<li class="linkedin">
					<a href="https://www.linkedin.com/pub/lam-huynh/102/179/52a" title="Link us on LinkedIn">
						<i class="fa fa-2x fa-linkedin"></i>
					</a>
				</li>
			</ul>
		</div> -->
	</div>
	<!-- /.navbar-collapse -->
</header>
