<?php

namespace portfolio\models;

use Yii;
use app\models\Banner;
use app\models\Tag;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property string $id
 * @property string $title
 * @property string $short_content
 * @property string $content
 * @property integer $status
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProjectTag[] $projectTags
 * @property Tag[] $tags
 * @property Banner[] $images
 */
class Project extends \yii\db\ActiveRecord
{
	private $_uploadImages;
	private $_tagValues = null;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['title', 'status', 'content'], 'required', 'on'=>['create', 'update'] ],
            [['short_content', 'content'], 'string'],
            [['status'], 'integer'],
            [['created_at', 'updated_at', 'uploadImages', 'tagValues'], 'safe'],
            [['title', 'slug'], 'string', 'max' => 255],
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
            'short_content' => 'Short Content',
            'content' => 'Content',
            'status' => 'Status',
            'slug' => 'Slug',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
			'tagValues' => 'Tags',
        ];
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
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjectTags()
    {
        return $this->hasMany(ProjectTag::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('{{%project_tag}}', ['project_id' => 'id']);
    }
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getImages()
    {
        return $this->hasMany(Banner::className(), ['id' => 'banner_id'])
            ->viaTable('{{%project_banner}}', ['project_id' => 'id']);
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
					'type' => Banner::TYPE_PROJECT,
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
			ProjectBanner::deleteAll(['project_id'=>$this->id]);
		}
		// save data and move images from upload folder
		/* @var $banner \app\models\Banner */
		foreach($this->getUploadImages() as $banner) {
			$banner->save();
			$banner->saveImage();
			$relation = new ProjectBanner([
				'project_id'=>$this->id,
				'banner_id'=>$banner->id
			]);
			$relation->save();
		}
		
		// delete unused banner
		$pb = ProjectBanner::tableName();
		$b = Banner::tableName();
		$banners = Banner::find()->where("type=:type and not exists (
			select *
			from $pb pb
			where pb.banner_id=$b.id
		   )", [':type'=>Banner::TYPE_PROJECT])->all();
		foreach($banners as $banner) {
			$banner->delete();
		}
	}
	
	public function getUrl() {
		$route = '/project/view';
		$params = [$route, 'id'=>$this->id];
		$params['slug'] = $this->slug;
		return Url::to($params, true);
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
			ProjectTag::deleteAll('project_id=:id', [':id'=>$this->id]);
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
			
			$at = new ProjectTag([
				'project_id'=>$this->id,
				'tag_id'=>$tag->id,
			]);
			$at->save();
		}
	}
	
    public function beforeDelete()
    {
		// remove banner
		foreach($this->images as $image) {
			$image->delete();
		}
		ProjectBanner::deleteAll(['project_id'=>$this->id]);
		return parent::beforeDelete();
    }
	
}
