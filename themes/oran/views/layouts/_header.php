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
	<div class="tagline text-center">
		<h4 class="heading">Lam Huynh</h4>
		<p>PHP Web Developer</p>
	</div>

	<button type="button" class="btn-nav" data-toggle="collapse" data-target="#left-navbar" aria-expanded="false">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

	<div id="left-navbar" class="collapse">
		<nav id="main-nav">
			<ul>
				<li class="what-i-do"><a href="<?= Url::to(['/portfolio/project']) ?>">Portfolio</a></li>
				<li class="about"><a href="<?= Post::getUrlBySlug('about') ?>">About</a></li>
				<li class="blog hide"><a href="<?= Url::to(['/blog']) ?>">Blog</a></li>
				<li class="contact"><a href="<?= Url::to(['/site/contact']) ?>">Contact</a></li>
			</ul>
		</nav>

		<div class="social-links">
			<ul class="list-inline">
				<li class="facebook">
					<a href="https://www.facebook.com/daibanglam" title="My Facebook" target="_blank">
						<i class="fa fa-2x fa-facebook-square"></i>
					</a>
				</li>
				<!-- <li class="twitter">
					<a href="https://twitter.com/mrsecon" title="Follow us on Twitter">
						<i class="fa fa-2x fa-twitter"></i>
					</a>
				</li> -->
				<li class="linkedin">
					<a href="https://vn.linkedin.com/in/lam-huynh-52a179102" title="LinkedIn" target="_blank">
						<i class="fa fa-2x fa-linkedin-square"></i>
					</a>
				</li>
			</ul>
		</div>
	</div>
	<!-- /.navbar-collapse -->
</header>
