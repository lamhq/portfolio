<?php
namespace diary\assets;

use yii\web\AssetBundle;

class DiaryAsset extends AssetBundle
{
    public function init(){
        $this->sourcePath = __DIR__ . '/diary-asset';
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
