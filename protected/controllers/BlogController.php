<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Post;
use app\models\Category;
use app\models\Tag;

class BlogController extends Controller {

    public function beforeAction($action) {
       $this->layout = 'blog';
       return parent::beforeAction($action);
    }

	public function actionIndex() {
		$query = Post::find()->active();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=>['defaultOrder' => ['updated_at'=>SORT_DESC]],
			'pagination' => [ 'pageSize' => 10 ],
		]);
		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionPost($id) {
		$model = Post::find()->active()->andWhere(['id' => $id])->one();
		if (!$model) {
			throw new \yii\web\HttpException(404, 'The requested page does not exist');
		}
		return $this->render('post', [
			'model' => $model
		]);
	}

	public function actionPage($id) {
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

	public function actionCategory($id) {
		$model = Category::findOne($id);
		if (!$model) {
			throw new \yii\web\HttpException(404, 'The requested page does not exist');
		}
		
		$query = $model->getPosts()
			->where([
				'status' => Post::STATUS_ACTIVE,
				'type' => Post::TYPE_POST
			]);
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=>['defaultOrder' => ['updated_at'=>SORT_DESC]],
			'pagination' => [ 'pageSize' => 10 ],
		]);
		$this->view->title = $model->name;
		return $this->render('category', [
			'dataProvider' => $dataProvider,
			'model' => $model,
		]);
	}

	public function actionTag($slug) {
		$model = Tag::find()->andWhere(['slug'=>$slug])->one();
		if (!$model) {
			throw new \yii\web\HttpException(404, 'The requested page does not exist');
		}
		
		$query = $model->getPosts()->active();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=>['defaultOrder' => ['updated_at'=>SORT_DESC]],
			'pagination' => [ 'pageSize' => 10 ],
		]);
		$this->view->title = sprintf('Posts tagged with "%s"', $model->name);
		return $this->render('category', [
			'dataProvider' => $dataProvider,
			'model' => $model,
		]);
		
	}

	public function actionSearch($s) {
		$query = Post::find()
			->active()->addSearchFilter($s);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort'=>['defaultOrder' => ['updated_at'=>SORT_DESC]],
			'pagination' => [ 'pageSize' => 10 ],
		]);
		return $this->render('search', [
			'term'=>trim($s, '"'),
			'dataProvider' => $dataProvider,
		]);
	}
}
