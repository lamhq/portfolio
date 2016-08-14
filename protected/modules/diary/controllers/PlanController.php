<?php

namespace diary\controllers;

use Yii;
use diary\models\Activity;
use diary\models\Plan;
use diary\models\Tag;
use diary\models\search\ActivitySearch;
use app\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;

/**
 * PlanController implements the CRUD actions for Activity model.
 */
class PlanController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

	public function actionIndex($y=null, $m=null)
	{
		$year = $y ?: date('Y');
		$month = $m ?: date('n');

		$items = Plan::find()
			->select([
				'p.*', // select all columns
				'SUM(act.outcome) AS outcome', // calculate outcome
			])
			->from(['p'=>Plan::tableName()])
			->where([
				'p.year' => $year,
				'p.month' => $month,
			])
			->joinWith([
				'tag' => function ($q) {
					$q->from(Tag::tableName().' tag');
				},
				'tag.activities' => function ($q) use ($year, $month) {
					$q
					->from(Activity::tableName().' act')
					->andOnCondition([
						'year(act.time)' => $year,
						'month(act.time)' => $month,
					]);
				},
			])
			->groupBy('p.id')
			->all();
		return $this->_render('index', [
			'year'=>$year,
			'month'=>$month,
			'items'=>$items
		]);
	}

	/*
	 * render report defect form in tenancy view page
	 * 
	 * @author Lam Huynh
	 */
	public function actionForm($id=null) {
		$model = $id ? $this->findModel($id) : new Plan(['scenario'=>'insert']);
		return $this->_render('_form', ['model' => $model]);
	}
	
	/**
	 * Finds the Activity model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Activity the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Plan::findOne($id)) !== null) {
			$model->scenario = 'update';
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

	/*
	 * ajax
	 * 
	 * @author Lam Huynh
	 */
	public function actionSave($id=null) {
		$result = false;
		$model = $id ? $this->findModel($id) : new Plan();

		// if it is ajax validation request
		if (Yii::$app->request->isAjax && !isset($_POST['ajax-submit']) && $model->load(Yii::$app->request->post())) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return ActiveForm::validate($model);
		}
		
		if ($model->load( Yii::$app->request->post() ) && $model->save()) {
			$result = true;
		}
		return intval($result);
	}

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return '1';
        return $this->redirect(['index']);
    }
}
