<?php

namespace app\components;

use app\models\Post;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class PostQuery extends ActiveQuery {

	public function addSearchFilter($s) {
		$terms = preg_match('/\".*?\"/', $s) ? [trim($s, '"')] : explode(' ', $s);
		foreach ($terms as $term) {
			$this->andWhere(
				['or', ['like', 'title', $term], ['like', 'content', $term], ['like', 'short_content', $term]]
			);			
		}
		return $this;
	}

	public function active() {
		return $this->andWhere(['status' => Post::STATUS_ACTIVE])
			->andWhere(['type' => Post::TYPE_POST]);
	}
}
