<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Category;
use yii\data\ActiveDataProvider;

class CategoryController extends Controller {

	public function actionView($slug) {
		$model = Category::find()->where([
			'slug' => $slug,
		])->one();
		if (!$model) {
			throw new \yii\web\HttpException(404, 'The requested page does not exist');
		}
		
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getPosts(),
			'pagination' => [
				'pageSize' => \Yii::$app->params['pageSize'],
			],
        ]);
		$this->layout = '2col-right';
		return $this->render('view', [
            'category' => $model,
            'dataProvider' => $dataProvider,
		]);
	}

}
