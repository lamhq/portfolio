<?php

namespace portfolio\models;

class Tag extends \app\models\Tag {
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%pf_tag}}';
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProjectTag()
	{
		return $this->hasMany(ProjectTag::className(), ['tag_id' => 'id']);
	}
}
