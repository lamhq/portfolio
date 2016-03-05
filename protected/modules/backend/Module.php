<?php

namespace backend;

class Module extends \yii\base\Module {

	public $defaultRoute = 'post';
	
	public function init() {
		parent::init();
		// custom initialization code:
//		$this->setViewPath('@webroot/themes/adminlte/views');
		\Yii::$app->view->theme->pathMap = [
			'@app/widgets/views' => '@webroot/themes/adminlte/views/widgets',
			'@app/modules/backend/views' => '@webroot/themes/adminlte/views',
		];

		\Yii::$app->user->loginUrl = ['backend/site/login'];
		$this->layout = 'main';
	}

}
