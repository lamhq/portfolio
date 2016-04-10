<?php

namespace app\components;

use yii\base\Action;
use Yii;
use app\components\Helper;

class AjaxUploadAction extends Action {

	public function run() {
		Yii::$app->controller->enableCsrfValidation = false;
		$response = array();
		try {
			// Check for errors
			if ($_FILES['ajax-file']['error'] > 0) {
				throw new Exception('An error ocurred when uploading.');
			}
			$filename = Helper::sanitize(time() . '-' . $_FILES['ajax-file']['name']);
			$filePath = Helper::getUploadFilePath($filename);
			$dir = dirname($filePath);
			if (!file_exists($dir)) {
				mkdir($dir, 0777, true);
			}
			// Upload file
			if (!move_uploaded_file($_FILES['ajax-file']['tmp_name'], $filePath)) {
				throw new Exception('Error uploading file - check destination is writeable.');
			}
			$response['value'] = $filename;
			$response['link'] = Helper::getUploadFileLink($filename);
			$response['status'] = 'success';
		} catch (Exception $ex) {
			$response['status'] = 'error';
			$response['message'] = $ex->getMessage();
		}
		return json_encode($response);
	}

}
