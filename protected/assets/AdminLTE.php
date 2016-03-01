<?php

/**
 * Created by PhpStorm.
 * User: zein
 * Date: 8/2/14
 * Time: 11:40 AM
 */

namespace app\assets;

use yii\web\AssetBundle;

class AdminLTE extends AssetBundle {

	public $sourcePath = '@bower/admin-lte/dist';
	
	public $js = [
		'js/app.min.js'
	];
	
	public $css = [
		'css/AdminLTE.min.css',
		'css/skins/_all-skins.min.css'
	];
	
	public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		'app\assets\FontAwesome',
	];

}
