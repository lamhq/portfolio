<?php
/**
 * @var $this yii\web\View
 */
use yii\helpers\Html;
use \app\models\Category;
use \app\models\Post;
?>
<div class="top-link">
	<div class="container clearfix">
		<div class="logo"><a href="http://onehome.sg"><img src="<?= $this->theme->baseUrl ?>/img/onehome-logo.png" alt="Onehome" /></a></div>
		<ul>
			<li><a href="http://onehome.sg/page/about-us">about us</a></li>
			<li><a href="http://onehome.sg/contact">contact us</a></li>
			<li><a href="http://onehome.sg/listing">property search</a></li>
		</ul>
	</div>
</div>

<header class="header-container bg">
	<img src="<?= $this->theme->baseUrl ?>/img/bg-header.jpg" alt="" class="bgimg" />
	<div class="container">
		<div class="group clearfix">
			<div class="category-drop">
				<a href="#category" class="control-sub btn-cate">category</a>
				<div id="category" class="sub-category">
					<a href="#category" class="control-sub glyphicon glyphicon-remove">close</a>
					<ul>
						<?php foreach(Category::find()->all() as $category): ?>
						<li><a href="<?= $category->url ?>"><?= Html::encode($category->name) ?></a></li>
						<?php endforeach ?>
					</ul>
				</div>
			</div>

			<?= app\widgets\Search::widget() ?>
		</div>
		<div class="head-intro">
			<h1>Welcome to our Onehome Community</h1>
		</div>
	</div>
	<div class="menu-wrap">
		<nav class="container">
			<ul>
				<li>
					<a href="<?= Category::getUrlBySlug('tips-and-guides') ?>">
						<span class="ico"><img src="<?= $this->theme->baseUrl ?>/img/ico-1.png" alt="" /></span>
						Tips &amp; Guides
					</a>
				</li>
				<li>
					<a href="<?= Category::getUrlBySlug('onehome-services') ?>">
						<span class="ico"><img src="<?= $this->theme->baseUrl ?>/img/ico-2.png" alt="" /></span>
						OneHome Services 
					</a>
				</li>
				<li>
					<a href="<?= Category::getUrlBySlug('property-news') ?>">
						<span class="ico"><img src="<?= $this->theme->baseUrl ?>/img/ico-3.png" alt="" /></span>
						Property News
					</a>
				</li>
				<li>
					<a href="<?= Category::getUrlBySlug('home-decor') ?>">
						<span class="ico"><img src="<?= $this->theme->baseUrl ?>/img/ico-4.png" alt="" /></span>
						Home Decor
					</a>
				</li>
				<li>
					<a href="<?= Category::getUrlBySlug('singapore-living') ?>">
						<span class="ico"><img src="<?= $this->theme->baseUrl ?>/img/ico-5.png" alt="" /></span>
						Singapore Living
					</a>
				</li>
				<li>
					<a href="http://onehome.sg/forum">
						<span class="ico"><img src="<?= $this->theme->baseUrl ?>/img/ico-6.png" alt="" /></span>
						Discussion Forum
					</a>
				</li>
			</ul>
		</nav>
	</div>
</header><!-- // header -->

