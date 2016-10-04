<?php

namespace blog\models;

use Yii;

/**
 * This is the model class for table "{{%bl_post_tag}}".
 *
 * @property integer $post_id
 * @property integer $tag_id
 */
class PostTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bl_post_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'tag_id'], 'required'],
            [['post_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'tag_id' => 'Tag ID',
        ];
    }
}
