<?php

namespace blog\controllers;

use Yii;
use blog\models\Post;
use blog\models\search\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionManage()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
		$searchModel = new PostSearch(['scenario'=>'search']);
		$params = $this->_getSearchParams();
		$searchModel->search($params);
		$this->_saveSearchParams($params);

        return $this->_render('index', [
            'searchModel' => $searchModel,
        ]);
    }
	
    /**
     * @return array
     */
	protected function _getSearchParams() {
		$post = Yii::$app->request->post();
		$cookie = json_decode(Yii::$app->request->cookies->getValue('post_search', '[]'), true);
		$params = array_merge($cookie, $post);
		return $params;
	}
	
	protected function _saveSearchParams($params) {
		if (isset($params['PostSearch'])) {
			// get the cookie collection (yii\web\CookieCollection) from the "response" component
			$cookies = Yii::$app->response->cookies;

			// add a new cookie to the response to be sent
			$cookies->add(new \yii\web\Cookie([
				'name' => 'post_search',
				'value' => json_encode(['PostSearch'=>$params['PostSearch']]),
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
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post(['scenario'=>'create']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model->saveTags();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			$model->saveTags();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
			$model->scenario = 'update';
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
