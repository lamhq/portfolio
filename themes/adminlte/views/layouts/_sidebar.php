<?php
/**
 * @var $this yii\web\View
 */
?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<?= app\widgets\Menu::widget([
			'options'=>['class'=>'sidebar-menu'],
			'labelTemplate' => '<a href="#">{icon}<span>{label}</span>{right-icon}{badge}</a>',
			'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
			'submenuTemplate'=>"\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
			'activateParents'=>true,
			'items'=>[
				// diary
				[
					'label'=>Yii::t('app', 'Diary'),
					'icon'=>'<i class="fa fa-bar-chart-o"></i>',
					'options'=>['class'=>'treeview'],
					'items'=>[
						['label'=>Yii::t('app', 'Timeline'), 'url'=>['/diary/activity'], 'icon'=>'<i class="fa fa-circle-o"></i>'],
						['label'=>Yii::t('app', 'Outcome'), 'url'=>['/diary/plan'], 'icon'=>'<i class="fa fa-circle-o"></i>'],
					],
				],
				['label'=>Yii::t('app', 'Note'), 'url'=>['/note/post'], 'icon'=>'<i class="fa fa-edit"></i>', ],
				['label'=>Yii::t('app', 'Project'), 'url'=>['/backend/project'], 'icon'=>'<i class="fa fa-briefcase"></i>'],
				['label'=>Yii::t('app', 'Banner'), 'url'=>['/backend/banner'], 'icon'=>'<i class="fa fa-circle-o"></i>'],
				['label'=>Yii::t('app', 'Post'), 'url'=>['/backend/post'], 'icon'=>'<i class="fa fa-circle-o"></i>'],
				['label'=>Yii::t('app', 'Page'), 'url'=>['/backend/page'], 'icon'=>'<i class="fa fa-circle-o"></i>'],
				['label'=>Yii::t('app', 'Category'), 'url'=>['/backend/category'], 'icon'=>'<i class="fa fa-circle-o"></i>'],
			]
		]) ?>
	</section>
	<!-- /.sidebar -->
</aside>

