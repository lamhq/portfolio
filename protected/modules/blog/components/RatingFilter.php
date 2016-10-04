<?php

namespace blog\components;

/**
 * @author Lam Huynh
 */
class RatingFilter {
	
    /**
     * Apply filter condition to the query object
     *
     * @param \yii\db\ActiveQuery $query
     * @param \blog\models\search\PostSearch $model the model hold the filter value
     */
	public function apply($query, $model) {
		if ($model->minRating) {
			$query->andFilterWhere(['>=', 'rating', $model->minRating]);
		}
	}
}
