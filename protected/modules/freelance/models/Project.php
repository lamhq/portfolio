<?php

namespace freelance\models;

use Yii;

/**
 * @property string $jsonBids
 */
class Project extends \yii\base\Model {

	public $jsonBids;
	public $bids;
	public $priceRange;
	public $dateRange;
	public $rateRange;
	public $avgRate;

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['jsonBids'], 'required'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		return [
			'default' => ['jsonBids'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
		return [
			'jsonBids' => 'Text',
			'avgRate' => 'Average rate',
			'priceRange' => 'Price',
			'dateRange' => 'Day',
			'rateRange' => 'Rate ($/hour)',
		];
	}

	public function parseJsonBid() {
		$min = $max = 0;
		$bids = json_decode($this->jsonBids, true);
		if (!is_array($bids))
			$bids = [];
		foreach ($bids as &$bid) {
			$bid['price'] = str_replace('$', '', $bid['price']);
			$bid['rate'] = $bid['price'] / $bid['period'];
		}

		extract($this->getRanges($bids, 'rate'));
		$this->rateRange = sprintf('%s - %s', $min, $max);
		$this->avgRate = ($min + $max)/2;
		
		extract($this->getRanges($bids, 'period'));
		$this->dateRange = sprintf('%s - %s', $min, $max);
		
		extract($this->getRanges($bids, 'price'));
		$this->priceRange = sprintf('%s - %s', $min, $max);
		$this->bids = $bids;
	}
	
	public function getRanges($items, $field) {
		$items = $this->arraySort($items, $field, SORT_ASC);
		$v = array_values($items);
		$first = array_shift($v);
		$last = end($items);
		return [
			'min'=>$first[$field], 
			'max'=>$last[$field]
		];
	}

	protected function arraySort($array, $on, $order = SORT_ASC) {
		$new_array = array();
		$sortable_array = array();

		if (count($array) > 0) {
			foreach ($array as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $k2 => $v2) {
						if ($k2 == $on) {
							$sortable_array[$k] = $v2;
						}
					}
				} else {
					$sortable_array[$k] = $v;
				}
			}

			switch ($order) {
				case SORT_ASC:
					asort($sortable_array);
					break;
				case SORT_DESC:
					arsort($sortable_array);
					break;
			}

			foreach ($sortable_array as $k => $v) {
				$new_array[$k] = $array[$k];
			}
		}

		return $new_array;
	}

}
