<?php
namespace app\widgets;

use yii\base\Widget;

/**
 * Class Menu
 * @package app\widget
 */
class Search extends Widget
{
    /**
     * Renders the menu.
     */
    public function run()
    {
		$text = isset($_GET['s']) ? $_GET['s'] : '';
		return $this->render('search', ['text'=>$text]);
    }   
}
