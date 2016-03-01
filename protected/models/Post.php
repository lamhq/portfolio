<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property integer $type
 * @property integer $status
 * @property string $slug
 * @property string $create_time
 * @property string $update_time
 * @property string $author_id
 * @property string $category_id
 *
 * @property Comment[] $comments
 * @property User $author
 * @property Category $category
 */
class Post extends \yii\db\ActiveRecord
{
	const TYPE_POST = 1;
	const TYPE_PAGE = 2;
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['type', 'status', 'author_id', 'category_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'type' => 'Type',
            'status' => 'Status',
            'slug' => 'Slug',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
	
	public function getUrl() {
		$route = $this->type == self::TYPE_PAGE ? 'page/view' : 'post/view';
		return Url::to([$route, 'slug' => $this->slug]);
	}
	
	static public function getUrlBySlug($slug) {
		$model = self::find()->where(['slug' => $slug])->one();
		return $model ? $model->url : '';
	}
}
