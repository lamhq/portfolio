<?php

namespace note\models;

use Yii;

/**
 * This is the model class for table "{{%bl_tag}}".
 *
 * @property integer $id
 * @property string $name
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bl_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
	
	static public function getListData() {
		$tagQuery = self::find()
			->from(self::tableName(). ' t')
			->orderBy('name');
		
		return yii\helpers\ArrayHelper::map($tagQuery->all(), 'id', 'name');
	}
}
