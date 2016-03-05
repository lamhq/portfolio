<?php

namespace app\models;

use Yii;
use app\components\Helper;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;


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
	
	private $_uploadImages;	// for create/update in backend

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
			[['title', 'status', 'content'], 'required', 'on'=>['create', 'update'] ],
			[['content'], 'string'],
			[['short_content', 'content'], 'string'],
			[['type', 'status', 'author_id', 'category_id'], 'integer'],
			[['created_at', 'updated_at', 'uploadImages'], 'safe'],
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
			'created_at' => 'Published Date',
			'updated_at' => 'Update Time',
			'author_id' => 'Author',
			'category_id' => 'Category',
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
		$route = $this->type == self::TYPE_PAGE ? '/page/view' : '/post/view';
		return Url::to([$route, 'id'=>$this->id, 'slug' => $this->slug], true);
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
			Helper::resize($srcImg, $imgFile, $width, $height, array('fit'=>false));
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
            1 => 'assets/cache',
            2 => self::UPLOAD_DIR,
            3 => $this->id,
            4 => "{$width}x{$height}",
            5 => $this->featured_image
        );
		if ($watermark)
			$paths[5] = 'w'.$paths[5];
        if (!$width && !$height) {
            unset ($paths[1]);
            unset ($paths[4]);
		}
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
            1 => 'assets/cache',
            2 => self::UPLOAD_DIR,
            3 => $this->id,
            4 => "{$width}x{$height}",
            5 => $this->featured_image
        );
		if ($watermark)
			$paths[5] = 'w'.$paths[5];
        if (!$width && !$height) {
            unset ($paths[1]);
            unset ($paths[4]);
		}
        return implode('/', $paths);
    }
	
	public function getPublishedDate() {
		return \app\components\Helper::toAppDate($this->created_at);
	}
	
	static public function getLatestPosts() {
		return Post::find()
			->with('category')
			->orderBy('created_at DESC')
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
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getImages()
    {
        return $this->hasMany(Banner::className(), ['id' => 'banner_id'])
            ->viaTable('{{%post_banner}}', ['post_id' => 'id']);
    }	
	
    public function beforeDelete()
    {
        // remove uploaded files
		$rm = implode(DIRECTORY_SEPARATOR, [Yii::getAlias('@webroot'), self::UPLOAD_DIR, $this->id]);
		\yii\helpers\FileHelper::removeDirectory($rm);
		// remove banner
		foreach($this->images as $image) {
			$image->delete();
		}
		PostBanner::deleteAll(['post_id'=>$this->id]);
		return parent::beforeDelete();
    }
	
	public function getUploadImages() {
		if ($this->_uploadImages===null) {
			$banners = $this->getImages()->all();
			$this->_uploadImages = \yii\helpers\ArrayHelper::map($banners, 'id', 'image');
		}
		return $this->_uploadImages;
	}
	
	public function setUploadImages($value) {
		$this->_uploadImages = $value;
	}
	
	public function saveUploadImages() {
		if (!$this->isNewRecord) {
			// move old images to upload folder
			// remove old banners
			foreach($this->images as $banner) {
				$from = $banner->generateImagePath();
				$to = implode(DIRECTORY_SEPARATOR, [Yii::getAlias('@webroot'),Yii::$app->params['ajaxUploadDir'],$banner->image]);
				if (is_file($from)) rename($from, $to);
				$banner->delete();
			}
			PostBanner::deleteAll(['post_id'=>$this->id]);
		}
		// save data and move images from upload folder
		foreach($this->_uploadImages as $image) {
			$banner = new Banner([
				'image'=> $image,
				'type' => Banner::TYPE_POST
			]);
			$banner->save();
			$banner->saveImage();
			$relation = new PostBanner([
				'post_id'=>$this->id,
				'banner_id'=>$banner->id
			]);
			$relation->save();
		}
	}
	
	public function saveFeaturedImage() {
		Helper::moveUploadedAjaxFile($this->featured_image, self::UPLOAD_DIR .DIRECTORY_SEPARATOR. $this->id);
	}
	
	public function behaviors() {
		return [
			[
				'class' => TimestampBehavior::className(),
				'value' => new Expression('NOW()'),
			],
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'title',
				'ensureUnique' => true,
				'immutable'=>true,
				// 'slugAttribute' => 'slug',
			],
		];
	}

}
