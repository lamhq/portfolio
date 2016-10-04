<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Description of AjaxUpload
 *
 * @author Lam Huynh
 */
class CategoryList extends Widget {
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the widget
	 */
	public function run() {
		$models = \app\models\Category::find()
		->orderBy('name')->all();
		return $this->render('category-list', [
			'models'=>$models,
		]);
	}

}
