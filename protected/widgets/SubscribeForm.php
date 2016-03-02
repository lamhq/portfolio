<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Class Menu
 * @package app\widget
 */
class SubscribeForm extends Widget
{
    public $type;
	
	/**
     * Renders the menu.
     */
    public function run()
    {
		$model = new \app\models\Subscriber();
		$model->scenario = 'insert';
		$model->load(\Yii::$app->request->post());
		if (\Yii::$app->request->isPost && $model->validate()) {
			$model->save();
			\Yii::$app->session->setFlash('alert', [
				'options'=>['class'=>'alert-success'],
				'body'=>'Your subscription has been saved.'
			]);
			\Yii::$app->controller->goHome();
			\Yii::$app->end();
		}
		return $this->render("subscribe-form", ['model'=>$model]);
    }   
}
