<?php

namespace app\models;

use Yii;
use app\components\ImageHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property string $id
 * @property string $title
 * @property string $short_content 
 * @property string $content
 * @property string $featured_image 
 * @property integer $type
 * @property integer $status
 * @property string $slug

 * @property string $category_id
 *
 * @property Comment[] $comments
 * @property FeaturedPost $featuredPost 
 * @property User $author
 * @property Category $category
 */
class Post extends \yii\db\ActiveRecord {

	const TYPE_POST = 1;
	const TYPE_PAGE = 2;
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	const UPLOAD_DIR = 'media/post';

	/**
	 * @inheritdoc
	 */
	public static function tableName() {
		return '{{%post}}';
	}

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['content'], 'string'],
			[['short_content', 'content'], 'string'],
			[['type', 'status', 'author_id', 'category_id'], 'integer'],
			[['create_time', 'update_time'], 'safe'],
			[['title', 'slug'], 'string', 'max' => 255],
			[['title', 'featured_image', 'slug'], 'string', 'max' => 255]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels() {
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
	public function getComments() {
		return $this->hasMany(Comment::className(), ['post_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthor() {
		return $this->hasOne(User::className(), ['id' => 'author_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategory() {
		return $this->hasOne(Category::className(), ['id' => 'category_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFeaturedPost() {
		return $this->hasOne(FeaturedPost::className(), ['id' => 'id']);
	}

	public function getUrl() {
		$route = $this->type == self::TYPE_PAGE ? 'page/view' : 'post/view';
		return Url::to([$route, 'slug' => $this->slug]);
	}

	static public function getUrlBySlug($slug) {
		$model = self::find()->where(['slug' => $slug])->one();
		return $model ? $model->url : '';
	}

	/*
	 * Return the resized image url
	 * 
	 * @author Lam Huynh
	 */
    public function getImageUrl($width=null, $height=null, $watermark=false) {
        $imgFile = $this->generateImagePath($width, $height, $watermark);
        if (!is_file($imgFile)) {
			// resize image
			$srcImg = $this->generateImagePath();
			ImageHelper::resize($srcImg, $imgFile, $width, $height, array('fit'=>false));
		}
		
        $imgUrl = $this->generateImageUrl($width, $height, $watermark);
        return is_file($imgFile) ? $imgUrl : null;
    }
    
	/*
	 * Generate the filename corresponding to the dimension
	 * Need to change the code when copy to another model
	 * 
	 * @author Lam Huynh
	 */
    protected function generateImagePath($width=null, $height=null, $watermark=false) {
        $paths = array(
            0 => Yii::getAlias('@webroot'),
            1 => self::UPLOAD_DIR,
            2 => $this->id,
            3 => "{$width}x{$height}",
            4 => $this->featured_image
        );
		if ($watermark)
			$paths[4] = 'w'.$paths[4];
        if (!$width && !$height)
            unset ($paths[3]);
        return implode('/', $paths);
    }
    
	/*
	 * Generate the image url corresponding to the dimension
	 * Need to change the code when copy to another model
	 * 
	 * @author Lam Huynh
	 */
    protected function generateImageUrl($width=null, $height=null, $watermark=false) {
        $paths = array(
            0 => Yii::getAlias('@web'),
            1 => self::UPLOAD_DIR,
            2 => $this->id,
            3 => "{$width}x{$height}",
            4 => $this->featured_image
        );
		if ($watermark)
			$paths[4] = 'w'.$paths[4];
        if (!$width && !$height)
            unset ($paths[2]);
        return implode('/', $paths);
    }
	
	public function getPublishedDate() {
		return \app\components\Helper::toAppDate($this->create_time);
	}
	
	static public function getLatestPosts() {
		return Post::find()
			->with('category')
			->orderBy('create_time DESC')
			->limit(5)
			->all();
	}
	
	static public function getMostViewedPosts() {
		return Post::find()
			->with('category')
			->orderBy('view_count DESC')
			->limit(5)
			->all();
	}
	
	public function getRelatedPosts() {
		return Post::find()
			->select('*, MATCH(title) AGAINST(:text IN BOOLEAN MODE) AS score')
			->where('MATCH(title) AGAINST(:text IN BOOLEAN MODE) and id<>:id',[
				':text'=>$this->title,
				':id'=>$this->id
			])
			->orderBy('score DESC')
			->limit(5)
			->all();
	}
}
