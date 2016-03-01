<?php

namespace freelance\controllers;

use freelance\models\Project;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller {

	/**
	 * Analyze project bids
	 * @return mixed
	 */
	public function actionIndex() {
		$model = new Project();
		
		$session = Yii::$app->session;
		if (isset($session['bids'])) {
			$model->jsonBids = $session['bids'];
		}
		
		if ($model->load(Yii::$app->request->post())) {
			$session['bids'] = $model->jsonBids;
		}
			
		$model->parseJsonBid();
		return $this->render('index', [
			'model'=>$model
		]);
	}

}
