<?php
namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public function init(){
        $this->sourcePath = __DIR__ . '/app-asset';
        parent::init();
    }
    
    public $css = [
        'css/style.css'
    ];
    
    public $js = [
        'js/app.js'
    ];

    public $depends = [
        'app\assets\AdminLTE',
    ];
}
