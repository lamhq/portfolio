<?php
namespace app\assets;

use yii\web\AssetBundle;

class BannerUpload extends AssetBundle
{
    public function init(){
        $this->sourcePath = __DIR__ . '/banner-upload';
        parent::init();
    }
    
    public $css = [
    ];
    
    public $js = [
        'script.js'
    ];

    public $depends = [
		'yii\web\JqueryAsset',
    ];
}
