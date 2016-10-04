<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Description of AjaxUpload
 *
 * @author Lam Huynh
 */
class TagList extends Widget {
	
	/*
	 * active query object for tags
	 */
	public $query;
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the widget
	 */
	public function run() {
		$tags = $this->query->orderBy('name')->all();
		return $this->render('tag-list', [
			'tags'=>$tags,
		]);
	}

}
