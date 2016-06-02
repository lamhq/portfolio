<?php
namespace app\assets;

use yii\web\AssetBundle;

class BlogTheme extends AssetBundle
{
    public $baseUrl = '@web/themes/blog';
    
    public $css = [
        'css/plugin.css',
        'css/main.css',
        'css/custom.css',
    ];
    
    public $js = [
        'js/plugin.js',
    ];

    public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		'app\assets\FontAwesome',
    ];
}
