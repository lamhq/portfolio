<?php
namespace app\assets;

use yii\web\AssetBundle;

class OranAsset extends AssetBundle
{
    public $baseUrl = '@web/themes/oran';
    
    public $css = [
        'css/style.css',
    ];
    
    public $js = [
    ];

    public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		'app\assets\FontAwesome',
    ];
}
