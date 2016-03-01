<?php

namespace todo\controllers;

use Yii;
use todo\models\form\PlanForm;
use todo\models\search\PlanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanController implements the CRUD actions for Plan model.
 */
class PlanController extends Controller {

	protected $_grid = 'plan-grid';
	
	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	/**
	 * Lists all Plan models.
	 * @return mixed
	 */
	public function actionIndex() {
		/* update the submitted model */
		$updModel = new PlanForm();
		if (Yii::$app->request->isPost) {
			$data = Yii::$app->request->post();
			$updModel = $this->findModel($data['PlanForm']['id']);
			if ($updModel && $updModel->load($data) && $updModel->save()) {
				Yii::$app->session->setFlash('alert', [
					'options'=>['class'=>'alert-success'],
					'body'=>'Data saved successfully.'
				]);
				return $this->redirect(['index']);
			}
		}
		
		/* get models to display in grid */
		$searchModel = new PlanSearch();
		$models = $searchModel->search(Yii::$app->request->queryParams);
		$grid = $this->_getGrid() ?: [ array_keys($models), [], []];

		return $this->render('index', [
			'models' => $models,
			'grid' => $grid,
			'updateModel' => $updModel
		]);
	}

	public function actionGridUpdate() {
		if (isset($_POST['data'])) {
			$this->_saveGrid($_POST['data']);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function beforeAction($action) {
		if ($action->id == 'grid-update') {
			Yii::$app->controller->enableCsrfValidation = false;
		}

		return parent::beforeAction($action);
	}

	/**
	 * Displays a single Plan model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id) {
		$model = $this->findModel($id);
		$model->import(isset($_POST['PlanForm']) ? $_POST['PlanForm'] : array());

		if (Yii::$app->request->isPost) {
			$model->saveTasks();
			Yii::$app->session->setFlash('alert', [
				'options'=>['class'=>'alert-success'],
				'body'=>'Data saved successfully.'
			]);
			$this->redirect(['view', 'id' => $id]);
		}

		return $this->render('view', [
			'model' => $model,
		]);
	}

	/*
	 * @param string $json
	 */
	protected function _saveGrid($data) {
		if ( !is_string($data) ) {
			$data = json_encode ($data);
		}
		Yii::$app->setting->set($this->_grid, $data);
	}
	
	/*
	 * @return array
	 */
	protected function _getGrid() {
		$setting = Yii::$app->setting->get($this->_grid, null, false);
		return $setting ? json_decode($setting, true) : null;
	}
	
	/**
	 * Creates a new Plan model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate() {
		$model = new PlanForm();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model->saveTaskString();
			$grid = $this->_getGrid();
			if ($grid) {
				$grid[0][] = $model->id;
				$this->_saveGrid($grid);
			}
			Yii::$app->session->setFlash('alert', [
				'options'=>['class'=>'alert-success'],
				'body'=>'Data saved successfully.'
			]);
			return $this->redirect(['index']);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Plan model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id) {
		$model = $this->findModel($id);
		$old = $model->taskString = $model->generateTaskString();

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if ($old != $model->taskString)
				$model->saveTaskString();
			Yii::$app->session->setFlash('alert', [
				'options'=>['class'=>'alert-success'],
				'body'=>'Data saved successfully.'
			]);
			return $this->redirect(['view', 'id' => $id]);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Plan model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id) {
		$this->findModel($id)->delete();
		Yii::$app->session->setFlash('alert', [
			'options'=>['class'=>'alert-success'],
			'body'=>'Data deleted successfully.'
		]);
		return $this->redirect(['index']);
	}

	/**
	 * Finds the Plan model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return PlanForm the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id) {
		if (($model = PlanForm::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}
	
	public function actionArchive($id) {
        $this->findModel($id)->archive();
		return $this->redirect(['index']);
	}
}
