<?php
namespace app\assets;

use yii\web\AssetBundle;

class Backend extends AssetBundle
{
    public $baseUrl = '@web/themes/adminlte';
    
    public $css = [
        'css/style.css'
    ];
    
    public $js = [
        'js/app.js'
    ];

    public $depends = [
		'yii\web\YiiAsset',
        'app\assets\AdminLTE',
    ];
}
