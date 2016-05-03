<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/5/14
 * Time: 11:16 AM
 */

namespace diary\widgets;

use yii\base\Widget;

/**
 * Display total income/outcome of all searched records
 */
class IncomeStatistics extends Widget {

    /**
     * @var yii\db\ActiveQuery
     */
    public $query;

    /**
     * @inheritdoc
     */
    public function run() {
		$q = $this->query;
		$i = $q->sum('income');
		$o = $q->sum('outcome');
		return $this->render('statistics', [
			'income' => $i,
			'outcome' => $o,
			'profit' => $i-$o
		]);
    }

}