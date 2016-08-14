<?php

namespace diary\models;

use Yii;

/**
 * This is the model class for table "{{%di_tag}}".
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
        return '{{%di_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 64]
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivities()
    {
        return $this->hasMany(Activity::className(), ['id' => 'activity_id'])
            ->viaTable('{{%di_tag_act}}', ['tag_id' => 'id']);
    }

    public static function getTagListData() {
        return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
    
}
