<?php

namespace app\components;

class Formatter extends \yii\i18n\Formatter {

	public function asVisualDate($val) {
		return Helper::ToInputDateFormat($val);
	}
	
	public function asPrice($val) {
		return number_format($val);
	}
	
}
