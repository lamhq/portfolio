<?php
namespace app\assets;

use yii\web\AssetBundle;

class HomeBannerAsset extends AssetBundle
{
    public $baseUrl = '@web/themes/blog';
    
    public $css = [];
    
    public $js = [
        'js/jquery.sliderControl.js',
        'js/jquery.carouFredSel-6.2.1-packed.js',
        'js/jquery.touchSwipe.min.js',
        'js/jquery.easing.1.3.js',
        'js/main.js',
    ];

    public $depends = [
		'app\assets\BlogAsset',
    ];
	
	public function registerAssetFiles($view) {
		parent::registerAssetFiles($view);
		ob_start(); ?>
		var config = [];
		config = {"ajaxurl":"http:\/\/www.propertyforum.com\/wp-admin\/admin-ajax.php","themename":"pressroom","home_url":"http:\/\/www.propertyforum.com","is_rtl":0,"color_scheme":"light"};
		<?php
		$js = ob_get_clean();
		$view->registerJs($js, \yii\web\View::POS_END);		
	}
}
