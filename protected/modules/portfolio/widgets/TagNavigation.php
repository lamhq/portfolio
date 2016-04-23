<?php
namespace portfolio\widgets;

use yii\base\Widget;
use portfolio\models\Tag;
use app\components\Helper;

/**
 * Description of AjaxUpload
 *
 * @author Lam Huynh
 */
class TagNavigation extends Widget {
	
	/**
	 * @var int id of current active tag
	 */
	public $activeTag = null;
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the widget
	 */
	public function run() {
		$tags = Tag::find()->innerJoinWith('projectTag',true)->all();
		return $this->render('tag-navigation', [
			'tags'=>$tags,
			'activeId'=> $this->activeTag
		]);
	}

}
