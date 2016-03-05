<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\LoginForm;
use app\models\AccountForm;
use app\models\Post;
use yii\data\ActiveDataProvider;

class SiteController extends Controller {

	public function actions() {
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
			'ajaxUpload' => 'app\components\AjaxUploadAction',
		];
	}

	/**
	 * @inheritdoc
	 */
	public function beforeAction($action)
	{            
		if ($action->id == 'ajaxUpload') {
			$this->enableCsrfValidation = false;
		}

		return parent::beforeAction($action);
	}

	public function actionIndex() {
		return $this->render('index');
	}

	public function actionLogin() {
		$this->layout = 'blank';
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', [
					'model' => $model
			]);
		}
	}

	public function actionLogout() {
		Yii::$app->user->logout();
		return $this->goHome();
	}

	public function actionAccount() {
		$user = Yii::$app->user->identity;
		$model = new AccountForm();
		$model->username = $user->username;
		$model->email = $user->email;
		if ($model->load($_POST) && $model->validate()) {
			$user->username = $model->username;
			$user->email = $model->email;
			if ($model->password) {
				$user->setPassword($model->password);
			}
			$user->save();
			Yii::$app->session->setFlash('alert', [
				'options' => ['class' => 'alert-success'],
				'body' => Yii::t('app', 'Your account has been successfully saved')
			]);
			return $this->refresh();
		}
		return $this->render('account', ['model' => $model]);
	}

	public function actionSearch($s='') {
		$query = Post::find()
			->where('title LIKE :s OR content LIKE :s',[
				':s'=>'%'.$s.'%',
			]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => \Yii::$app->params['pageSize'],
			],
        ]);
		$this->layout = '2col-right';
		return $this->render('search', [
            'search' => $s,
            'dataProvider' => $dataProvider,
		]);
		
	}
}
