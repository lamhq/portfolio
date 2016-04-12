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

 *
 * @property Comment[] $comments
 * @property FeaturedPost $featuredPost 
 * @property User $author
 * @property Category $category
 * @property Category[] $categories
 * @property Banner[] $images
 */
class Post extends \yii\db\ActiveRecord {

	const TYPE_POST = 1;
	const TYPE_PAGE = 2;
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	const UPLOAD_DIR = 'media/post';
	
	/* for create/update in backend */
	private $_uploadImages;
	private $_selectedCategories;
	private $_tagValues = null;

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
			[['short_content', 'content'], 'string'],
			[['type', 'status', 'author_id'], 'integer'],
			[['created_at', 'updated_at', 'uploadImages', 'selectedCategories', 'tagValues'], 'safe'],
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
			'selectedCategories' => 'Categories',
			'tagValues' => 'Tags',
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
		return $this->hasOne(Category::className(), ['id' => 'category_id'])
			->viaTable('{{%post_category}}', ['post_id' => 'id']);        
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCategories() {
		return $this->hasMany(Category::className(), ['id' => 'category_id'])
			->viaTable('{{%post_category}}', ['post_id' => 'id']);        
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getFeaturedPost() {
		return $this->hasOne(FeaturedPost::className(), ['id' => 'id']);
	}

	public function getUrl() {
		$route = $this->type == self::TYPE_PAGE ? '/page/view' : '/post/view';
		$params = [$route, 'id'=>$this->id];
		if ($this->category)
			$params['cat'] = $this->category->slug;
		$params['slug'] = $this->slug;
		return Url::to($params, true);
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
    public function generateImagePath($width=null, $height=null, $watermark=false) {
        $paths = array(
            0 => Yii::getAlias('@webroot'),
            1 => 'assets',
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
            0 => Url::base(true),
            1 => 'assets',
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
	
	/**
	 * @return Post[]
	 */
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
			$this->_uploadImages = $this->getImages()->all();
		}
		return $this->_uploadImages;
	}
	
	public function setUploadImages($value) {
		if (!is_array($value)) throw new Exception ('uploaded images must be an array.');
		$models = [];
		/* @var $model \app\models\Banner */
		foreach($value as $data) {
			// import form data [id?, image]
			if (is_array($data)) {
				$model = new Banner([
					'image' => $data['image'],
					'type' => Banner::TYPE_POST,
				]);
				if (isset($data['id'])) {
					$model->id = $data['id'];
					$model->isNewRecord = false;
				}
			} else {
				$model = $data;
			}
			$models[] = $model;
		}
		$this->_uploadImages = $models;
	}
	
	public function saveUploadImages() {
		if (!$this->isNewRecord) {
			PostBanner::deleteAll(['post_id'=>$this->id]);
		}
		// save data and move images from upload folder
		/* @var $banner \app\models\Banner */
		foreach($this->getUploadImages() as $banner) {
			$banner->save();
			$banner->saveImage();
			$relation = new PostBanner([
				'post_id'=>$this->id,
				'banner_id'=>$banner->id
			]);
			$relation->save();
		}
		
		// delete unused banner
		$pb = PostBanner::tableName();
		$b = Banner::tableName();
		$banners = Banner::find()->where("type=:type and not exists (
			select *
			from $pb pb
			where pb.banner_id=$b.id
		   )", [':type'=>Banner::TYPE_POST])->all();
		foreach($banners as $banner) {
			$banner->delete();
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
				'immutable'=>false,
				// 'slugAttribute' => 'slug',
			],
		];
	}

	public function getSelectedCategories() {
		if ($this->_selectedCategories===null) {
			$cats = $this->getCategories()->all();
			$this->_selectedCategories = \yii\helpers\ArrayHelper::map($cats, 'id', 'id');
		}
		return $this->_selectedCategories;
	}
	
	public function setSelectedCategories($value) {
		$this->_selectedCategories = $value;
	}
	
	public function saveSelectedCategories() {
		if (!$this->isNewRecord) {
			// remove all relationship records
			PostCategory::deleteAll(['post_id'=>$this->id]);
		}
		// selected categories
		foreach($this->getSelectedCategories() as $catId) {
			$rel = new PostCategory([
				'post_id' => $this->id,
				'category_id'=> $catId,
			]);
			$rel->save();
		}
	}
	
	// explicitly list every field, best used when you want to make sure the changes
	// in your DB table or model attributes do not cause your field changes (to keep API backward compatibility).
	public function fields()
	{
		return [
			'title','short_content','url','publishedDate','url',
			'image' => function () {
				return $this->getImageUrl(261,142);
			},
			'author' => function () {
				return $this->author->username;
			},
		];
	}

	public function getTagValues() {
		if ($this->_tagValues===null) {
			$names = [];
			foreach ($this->tags as $tag) {
				$names[] = $tag->name;
			}
			$this->_tagValues = $names;
		}
		return $this->_tagValues;
	}
	
	public function setTagValues($value) {
		$this->_tagValues = $value;
	}
	
	public function saveTags() {
		// delete all tags belong to this activity
		if (!$this->isNewRecord)
			PostTag::deleteAll('post_id=:id', [':id'=>$this->id]);
		// save new tags
		$names = is_array($this->_tagValues) ? $this->_tagValues : [];
		foreach ($names as $name) {
			$name = trim($name);
			if (!$name) continue;
			
			$tag = Tag::find()
				->where(['name' => $name])
				->one();
			
			if (!$tag) {
				$tag = new Tag(['name'=>$name]);
				$tag->save();
			}
			
			$at = new PostTag([
				'post_id'=>$this->id,
				'tag_id'=>$tag->id,
			]);
			$at->save();
		}
	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
		return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%post_tag}}', ['post_id' => 'id']);
    }
	
}
