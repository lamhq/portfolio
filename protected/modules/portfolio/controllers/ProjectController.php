<?php
namespace portfolio\controllers;

use yii\web\Controller;
use \yii\data\ActiveDataProvider;
use portfolio\models\Project;

class ProjectController extends Controller {
	
	public function actionIndex($tag=null) {
		$query = Project::find()->where(['status'=>  Project::STATUS_ACTIVE]);
		if ($tag) {
			$query->innerJoinWith(['tags'=> function($query) use ($tag) {
				$query->andWhere('my_tag.slug LIKE :tag', [':tag'=>$tag]);
			}], true);
		}
		
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=>['defaultOrder' => ['updated_at'=>SORT_DESC]],
			'pagination' => [ 'pageSize' => 10 ],
        ]);
		return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
	}

	public function actionView($id) {
		$model = Project::find()->where([
			'id' => $id,
			'status' => Project::STATUS_ACTIVE
		])->one();
		if (!$model) {
			throw new \yii\web\HttpException(404, 'The requested page does not exist');
		}
		return $this->render('view', [
			'model' => $model
		]);
	}

}