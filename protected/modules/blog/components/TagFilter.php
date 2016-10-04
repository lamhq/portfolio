<?php

namespace blog\components;
use blog\models\PostTag;

/**
 * @author Lam
 */
class TagFilter {
	
    /**
     * Apply filter condition to the query object
     *
     * @param \yii\db\ActiveQuery $query
     * @param \yii\base\Model $model the model hold the filter value
     */
	public function apply($query, $model) {
		if (!is_array($model->searchTags) || !$model->searchTags) return;
		$tags = implode(',', $model->searchTags);
		if (!$tags) return;
		
		// find post have all selected tags
		$query
			->innerJoin(PostTag::tableName().' pt', 'p.id=pt.post_id')
			->andWhere(sprintf("pt.tag_id IN (%s)", $tags))
			->groupBy('p.id')
			->having('count(pt.tag_id)='.count($model->searchTags));
	}
}
