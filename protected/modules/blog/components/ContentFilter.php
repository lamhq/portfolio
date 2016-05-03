<?php

namespace blog\components;

/**
 * @author Lam
 */
class ContentFilter {
	
    /**
     * Apply filter condition to the query object
     *
     * @param \yii\db\ActiveQuery $query
     * @param \yii\base\Model $model the model hold the filter value
     */
	public function apply($query, $model) {
		if ($model->key) {
			$query->andWhere('title like :key or content like :key', [
				'key' => '%'.$model->key.'%'
			]);
		}
	}
}
