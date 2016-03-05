<?php
namespace app\assets;

use yii\web\AssetBundle;

class AjaxUpload extends AssetBundle
{
    public function init(){
        $this->sourcePath = __DIR__ . '/ajax-upload';
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
