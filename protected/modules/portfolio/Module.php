<?php

namespace portfolio;

class Module extends \yii\base\Module {

	public function init() {
		\Yii::$app->view->theme->pathMap['@app/modules/portfolio/views'] = '@webroot/themes/oran/views/portfolio';
		return parent::init();
	}

}
