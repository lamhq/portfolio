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
	
	/*
	 * project id to filter tag list
	 */
	public $project = false;
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the widget
	 */
	public function run() {
		$active = \Yii::$app->request->get('tag');
		$query = Tag::find()->innerJoinWith('projectTag',true);
		if ($this->project) {
			$query->andWhere(['project_id'=>$this->project]);
		}
		$tags = $query->all();
		return $this->render('tag-navigation', [
			'tags'=>$tags,
			'activeTag'=> $active,
			'project' => $this->project
		]);
	}

}
