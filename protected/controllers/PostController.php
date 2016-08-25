<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Post;

class PostController extends Controller {

	public function actionView($id=5) {
		$model = Post::find()->where([
			'id' => $id,
			'status' => Post::STATUS_ACTIVE
		])->one();
		if (!$model) {
			throw new \yii\web\HttpException(404, 'The requested page does not exist');
		}
		$model->view_count++;
		$model->update(['view_count']);
		$this->layout = '2col-right';
		return $this->render('view', [
			'post' => $model
		]);
	}

}
