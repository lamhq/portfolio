<?php

namespace diary\controllers;

use Yii;
use diary\models\Activity;
use diary\models\search\ActivitySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ActivityController implements the CRUD actions for Activity model.
 */
class ActivityController extends Controller
{
	/**
     * Lists all Activity models.
     * @return mixed
     */
    public function actionIndex()
    {
		$post = Yii::$app->request->post();
		return $this->_renderTimelinePage($post);
    }
	
     protected function _renderTimelinePage($params=array()) {
		/*
		 * need to put all the delete, create,update, search task in one place
		 * because many forms in the same page
		 */
		// do delete
		if (isset($params['delete'])) {
			$this->findModel($params['delete'])->delete();
		}
		
		// do search
		$searchModel = new ActivitySearch(['scenario'=>'search']);
		$sp = $this->_getSearchParams($params);
		$searchModel->search($sp);
		$this->_saveSearchParams($sp);
		
		// do create & update
		$model = new Activity(['scenario'=>'create']);
		if ( isset($params['Activity']) ) {
			$act = $params['Activity'];
			if ( !isset($act['id']) )
				throw new \yii\web\HttpException('Missing id parameter');
			
			$id = $act['id'];
			if ( $id ) {
				$model = Activity::findOne($params['Activity']['id']);
				$model->scenario = 'update';
			}
		}
		
		if ($model->load($params, 'Activity') && $model->save()) {
			$model->saveTags();
			return $this->_renderTimelinePage();
		}
		
        return $this->_render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
        ]);		
	}
	
   /**
     * @return array
     */
	protected function _getSearchParams($params=array()) {
		$cookie = json_decode(Yii::$app->request->cookies->getValue('act_search', '[]'), true);
		$result = array_merge($cookie, $params);
		if (!isset($result['ActivitySearch'])) {
			$result['ActivitySearch'] = array('dateRange'=>'month');
		}
		return $result;
	}
	
	protected function _saveSearchParams($params) {
		if (isset($params['ActivitySearch'])) {
			// get the cookie collection (yii\web\CookieCollection) from the "response" component
			$cookies = Yii::$app->response->cookies;

			// add a new cookie to the response to be sent
			$cookies->add(new \yii\web\Cookie([
				'name' => 'act_search',
				'value' => json_encode(['ActivitySearch'=>$params['ActivitySearch']]),
				'expire' => time()+3600*3
			]));
		}
	}

	protected function _render($view, $params) {
		if (Yii::$app->request->isAjax) {
			$content = $this->renderPartial($view, $params);
			$scripts = implode("\n", $this->getView()->js[\yii\web\View::POS_READY]);
			$content .= \yii\helpers\Html::script($scripts, ['type' => 'text/javascript']);
		} else {
			$content = $this->render($view, $params);
		}
		return $content;
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
        if (($model = Activity::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
