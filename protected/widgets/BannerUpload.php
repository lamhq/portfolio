<?php
namespace app\widgets;
use \yii\widgets\InputWidget;
use app\components\Helper;

/**
 * Description of AjaxUpload
 *
 * @author Lam Huynh
 */
class BannerUpload extends InputWidget {
	
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
		$model = $this->model;
		$attr = $this->attribute;
		$value = $model->$attr;
		if (!is_array($value)) {
			$value = [$value];
		}
		
		/* @var $banner \app\model\Banner */
		$items = [];
		foreach($value as $banner) {
			$data = [
				'id' => $banner->id,
				'image'=>$banner->image,
				'url' => $banner->isNewRecord ? 
					Helper::getUploadFileLink($banner->image) : 
					$banner->imageUrl
			];
			$items[] = $data;
		}
		return $this->render('banner-upload-widget', [
			'items'=>$items,
			'options'=>$this->options
		]);
	}

	/**
	 * Registers the needed CSS and JavaScript.
	 */
	public function registerClientScript()
	{
		$view=$this->view;
		\app\assets\BannerUpload::register($view);
		$this->options = array_merge([
			'id' => $this->id,
			'uploadUrl' => $this->uploadUrl,
			'extensions' => $this->extensions,
			'maxSize' => $this->maxSize,
			'multiple' => $this->multiple,
		], $this->options);
		if (!isset($this->options['name'])) {
			$this->options['name'] = \yii\helpers\Html::getInputName($this->model, $this->attribute);
		}
		$options = json_encode($this->options);
		$view->registerJs("setupBannerUploadWidget({$options});");
	}

}
