<?php
namespace app\widgets;

use yii\base\Widget;
/**
 * Description of FacebookPage
 *
 * @author MAX
 */
class FacebookShareButton extends Widget {
	
	public $url;
	
	/**
     * Renders
     */
    public function run()
    {
		return $this->render("facebook-share-button", ['url'=>$this->url]);
    }   
}
