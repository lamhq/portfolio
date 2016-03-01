<?php
namespace app\assets;

use yii\web\AssetBundle;

class BlogAsset extends AssetBundle
{
    public $baseUrl = '@web/themes/blog';
    
    public $css = [
        'css/plugin.css',
        'css/main.css',
    ];
    
    public $js = [
        'js/plugin.js'
    ];

    public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		'app\assets\FontAwesome',
    ];
}
