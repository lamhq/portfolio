<?php

namespace app\components;

class Formatter extends \yii\i18n\Formatter {

	public function asVisualDate($val) {
		return Helper::ToInputDateFormat($val);
	}
	
	public function asPrice($val) {
		return number_format($val);
	}
	
	public function formatEnum($value, $type=null) {
		if (!$value) return '';
		return \app\models\Lookup::item($type, $value);
	}
	
	public function formatYesNo($value) {
		return $value ? 'Yes' : 'No';
	}
}
