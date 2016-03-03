<?php
namespace app\assets;

use yii\web\AssetBundle;

class BackendAsset extends AssetBundle
{
    public function init(){
        $this->sourcePath = __DIR__ . '/backend-asset';
        parent::init();
    }
    
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
