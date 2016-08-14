<?php

namespace app\components;

use Yii;
use yii\web\Controller;

/**
 * PlanController implements the CRUD actions for Activity model.
 */
class BaseController extends Controller
{
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

}