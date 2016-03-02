<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%featured_post}}".
 *
 * @property string $id
 *
 * @property Post $id0
 */
class FeaturedPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%featured_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'id']);
    }
	
    /**
     * @return \app\models\Post[]
     */
	static public function getPosts() {
		return Post::find()
			->innerJoinWith('featuredPost')
			->with('category')
			->all();
	}
}
