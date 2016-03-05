<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%post_banner}}".
 *
 * @property string $post_id
 * @property string $banner_id
 */
class PostBanner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post_banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'banner_id'], 'required'],
            [['post_id', 'banner_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'banner_id' => 'Banner ID',
        ];
    }
}
