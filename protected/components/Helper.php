<?php

namespace app\components;

class Helper {

	public static function toDbDateTimeFormat($value) {
		$d = date_create_from_format('d/m/Y H:i:s', $value);
		if (!$d) return null;
		return $d->format('Y-m-d H:i:s');
	}
	
	public static function toDbDateFormat($value) {
		$d = date_create_from_format('d/m/Y', $value);
		if (!$d) return null;
		return $d->format('Y-m-d');
	}
	
	public static function toInputDateFormat($val) {
		$d = strtotime($val);
		if (!$d) return null;
		return date('d/m/Y', $d);
	}
	
	public static function mergeArray(&$a, $b) {
		foreach ($b as $key => $item) {
			if (is_array($item) && isset($a[$key]) && is_array($a[$key])) {
				self::mergeArray($a[$key], $item);
			} else {
				$a[$key] = $item;
			}
		}
	}
}
