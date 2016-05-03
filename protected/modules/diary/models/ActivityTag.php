<?php

namespace diary\models;

use Yii;

/**
 * This is the model class for table "{{%di_tag_act}}".
 *
 * @property integer $tag_id
 * @property integer $activity_id
 */
class ActivityTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%di_tag_act}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'activity_id'], 'required'],
            [['tag_id', 'activity_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'activity_id' => 'Activity ID',
        ];
    }
}
