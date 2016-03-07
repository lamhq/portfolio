<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $id
 * @property string $name
 *
 * @property Post[] $posts
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255]
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
    public function getPosts()
    {
		return $this->hasMany(Post::className(), ['id' => 'post_id'])
			->viaTable('{{%post_category}}', ['category_id' => 'id']);        
    }
	
	public function getUrl() {
		return Url::to(['/category/view', 'id'=>$this->id, 'slug' => $this->slug]);
	}
	
	static public function getUrlBySlug($slug) {
		$model = self::find()->where(['slug' => $slug])->one();
		return $model ? $model->url : '';
	}
	
	static public function getListData() {
		return \yii\helpers\ArrayHelper::map(self::find()->all(), 'id', 'name');
	}
}
