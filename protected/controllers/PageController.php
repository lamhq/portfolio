<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Post;

class PageController extends Controller {

	public function actionView($id) {
		$model = Post::find()->where([
			'id' => $id,
			'status' => Post::STATUS_ACTIVE
		])->one();
		if (!$model) {
			throw new \yii\web\HttpException(404, 'The requested page does not exist');
		}
		return $this->render('view', [
			'post' => $model
		]);
	}
}
