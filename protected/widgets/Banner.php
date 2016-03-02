<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Class Menu
 * @package app\widget
 */
class Banner extends Widget
{
    public $type;
	
	/**
     * Renders the menu.
     */
    public function run()
    {
		$banners = \app\models\Banner::find()->where(['type' => $this->type])->all();
		switch ($this->type) {
			case \app\models\Banner::TYPE_RIGHT:
				$view = 'right';
				break;

			case \app\models\Banner::TYPE_BOTTOM:
				$view = 'bottom';
				break;

			default:
				$view = 'right';
				break;
		}
		return $this->render("banner/$view", ['banners'=>$banners]);
    }   
}
