<?php
namespace portfolio\controllers;

use yii\web\Controller;
use \yii\data\ActiveDataProvider;
use portfolio\models\Project;

class ProjectController extends Controller {
	
	public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Project::find()->where(['status'=>  Project::STATUS_ACTIVE]),
			'sort'=>['defaultOrder' => ['updated_at'=>SORT_DESC]],
			'pagination' => [ 'pageSize' => 10 ],
        ]);
		return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
	}


}