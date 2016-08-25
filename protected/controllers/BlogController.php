<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Post;

class BlogController extends Controller {

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionPost($id) {
		return $this->render('post');
	}

	public function actionTopics() {
		
	}

	public function actionTopic() {
		
	}

	public function actionSearch() {
		
	}
}
