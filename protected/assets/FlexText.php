<?php

namespace app\assets;

use yii\web\AssetBundle;

class FlexText extends AssetBundle {

    public function init(){
        $this->sourcePath = __DIR__ . '/flex-text';
        parent::init();
    }
 	
	public $js = [
		'jquery.flexText.min.js',
	];
	
	public $css = [
		'flex-text.css'
	];
	
	public $depends = [
		'yii\web\JqueryAsset',
	];

}
