<?php
namespace app\assets;

use yii\web\AssetBundle;

class BackendTheme extends AssetBundle
{
    public $baseUrl = '@web/themes/adminlte';
    
    public $css = [
        'css/style.css'
    ];
    
    public $js = [
        'js/common.js',
        'js/blog.js',
        'js/diary.js',
    ];

    public $depends = [
		'yii\web\YiiAsset',
        'app\assets\AdminLTE',
    ];
}
