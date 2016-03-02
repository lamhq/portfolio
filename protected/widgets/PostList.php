<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Class Menu
 * @package app\widget
 */
class PostList extends Widget
{
    const TYPE_RECENT = 'recent';
    const TYPE_RELATED = 'related';
	
	public $type;
	public $posts = [];
	
	/**
     * Renders the menu.
     */
    public function run()
    {
		switch ($this->type) {
			case self::TYPE_RECENT:
				$view = 'recent';
				break;

			case self::TYPE_RELATED:
				$view = 'related';
				break;

			default:
				$view = 'recent';
				break;
		}
		return $this->render("post-list/$view", ['posts'=>$this->posts]);
    }   
}
