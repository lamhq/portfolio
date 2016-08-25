<?php

namespace note\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use note\models\Tag;
use note\models\PostTag;

/**
 * This is the model class for table "{{%bl_post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $created_time
 * @property string $updated_time
 * @property integer $rating
 */
class Post extends \yii\db\ActiveRecord
{
    const RATING_MIN = 1;
    const RATING_MAX = 5;
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%bl_post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['title', 'content'], 'required'],
            [['content'], 'string'],
            [['created_time', 'updated_time'], 'safe'],
            [['rating'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
	public function scenarios()
    {
        return [
            'create' => ['title', 'content', 'rating', 'tagValues'],
            'update' => ['title', 'content', 'rating', 'tagValues'],
            'default' => ['content'],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
				'class'=>TimestampBehavior::className(),
				'createdAtAttribute'=>'created_time',
				'updatedAtAttribute'=>'updated_time',
				'value'=>function () {
					return date('Y-m-d H:i:s');
				},
			]
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
            'created_time' => 'Created Time',
            'updated_time' => 'Updated Time',
            'rating' => 'Rating',
        ];
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
		return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%bl_post_tag}}', ['post_id' => 'id']);
    }
	
	protected $_tagValues = null;
	
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
		
		// delete empty tag
		Tag::deleteAll('id not in (select tag_id from {{%bl_post_tag}})');
	}
	
	protected static $_tagListData = null;
	
	public function getTagListData() {
		if (self::$_tagListData===null) {
			self::$_tagListData = \yii\helpers\ArrayHelper::map(Tag::find()->all(), 'id', 'name');
		}
		return self::$_tagListData;
	}
	
	public function getFormattedContent() {
		$content = \kartik\markdown\Markdown::convert($this->content);
		
		// add target blank to anchor
		$pattern = '/<a (.*?)>/i';
		$replacement = '<a target="_blank" ${1}>';
		$content = preg_replace($pattern, $replacement, $content);
		
		// remove img inline style
		$pattern = '/<img(.*?)style=".*?"(.*?)>/i';
		$replacement = '<img${1}${2}>';
		$content = preg_replace($pattern, $replacement, $content);

		// add responsive class to image
//		$pattern = '/<img(.*?)class="(.*?)"(.*?)>/i';
//		$replacement = '<img${1}class="${2} img-responsive"${3}>';
//		$result = preg_replace($pattern, $replacement, $result);

		return $content;
	}
}
