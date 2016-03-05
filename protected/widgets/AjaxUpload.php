<?php
namespace app\widgets;
use \yii\widgets\InputWidget;

/**
 * Description of AjaxUpload
 *
 * @author Lam Huynh
 */
class AjaxUpload extends InputWidget {
	
	/**
	 * @var string url to submit the file
	 */
	public $uploadUrl;
	
	/**
	 * @var boolean allow multiple file upload
	 */
	public $multiple = false;
	
	/**
	 * @var array allowed file extension
	 */
	public $extensions = array();
	
	/**
	 * @var float the maximum file size for upload in KB. 
	 * If set to 0, it means size allowed is unlimited. Defaults to 0.
	 */
	public $maxSize = 0;
	
	/**
	 * Executes the widget.
	 * This method registers all needed client scripts and renders
	 * the widget
	 */
	public function run() {
		$this->id = 'yw'.time().rand(0,99);
		$this->registerClientScript();
		return $this->render('ajax-upload-widget', [
			'model'=>$this->model,
			'attribute'=>$this->attribute,
			'options'=>$this->options
		]);
	}

	/**
	 * Registers the needed CSS and JavaScript.
	 */
	public function registerClientScript()
	{
		$view=$this->view;
		\app\assets\AjaxUpload::register($view);
		$this->options = array_merge([
			'id' => $this->id,
			'uploadUrl' => $this->uploadUrl,
			'extensions' => $this->extensions,
			'maxSize' => $this->maxSize,
			'multiple' => $this->multiple,
			'name'=> \yii\helpers\Html::getInputName($this->model, $this->attribute)
		], $this->options);
		$options = json_encode($this->options);
		$view->registerJs("setupAjaxUploadWidget({$options});");
	}

}
