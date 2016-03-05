<?php
namespace app\widgets;

use yii\base\Widget;
/**
 * Description of FacebookPage
 *
 * @author MAX
 */
class FacebookPage extends Widget {
	/**
     * Renders
     */
    public function run()
    {
		return $this->render("facebook-page");
    }   
}
