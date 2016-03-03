<?php

namespace app\components;

class Helper {

	/*
	 * convert input date (from view) to database date format
	 */
	public static function toDbDate($value) {
		$d = date_create_from_format(Yii::$app->params['dateFormat'], $value);
		if (!$d) return null;
		return $d->format('Y-m-d H:i:s');
	}
	
	/*
	 * convert datebase date to view format
	 */
	public static function toAppDate($value) {
		$t = strtotime($value);
		if (!$t) return null;
		return date(\Yii::$app->params['dateFormat'], $t);
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
