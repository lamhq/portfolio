<?php
namespace app\widgets;

use yii\base\Widget;
use yii\web\View;
use yii\helpers\Html;

/**
 * Class Menu
 * @package app\widget
 */
class AddThis extends Widget
{
    public $url;
    public $title;
	
	/**
     * Renders the menu.
     */
    public function run()
    {
		$this->view->registerJsFile('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56133df5326f44f0', [
			'position' => View::POS_END,
			'async'=>'async'
		]);
		return Html::tag('div', '', [
			'class' => 'addthis_native_toolbox',
			'data-title' => $this->title,
			'accesskey' => '',
			'data-url' => $this->url
		]);
    }   
}
