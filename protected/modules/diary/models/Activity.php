<?php

namespace diary\models;

use Yii;
use diary\models\Tag;

/**
 * This is the model class for table "{{%di_activity}}".
 *
 * @property integer $id
 * @property string $time
 * @property string $note
 * @property string $income
 * @property string $outcome
 * @property Tag[] $tags
 */
class Activity extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%di_activity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['note'], 'string'],
            [['income', 'outcome'], 'number'],
			
            [['note', 'inputTime'], 'required', 'on'=>['create', 'update']],
        ];
    }

    /**
     * @inheritdoc
     */
	public function scenarios()
    {
        return [
            'create' => ['note','inputTime', 'income','outcome','tagValues'],
            'update' => ['note','inputTime', 'income','outcome','tagValues', 'id'],
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time' => 'Time',
            'note' => 'Content',
            'income' => 'Income',
            'outcome' => 'Outcome',
			'inputTime' => 'Date time'
        ];
    }
	
    /**
     * Date display in timeline. i.e: Tue, 16 Jun 2015
     */
 	public function getTimeLineDate() {
		$t = strtotime($this->time);
		if (!$t) return '';
		
		$today = date('Y-m-d');
		if ($today==date('Y-m-d', $t))
			return 'Today';
		
		$yesterday = date('Y-m-d', strtotime("yesterday"));
		if ($yesterday==date('Y-m-d', $t))
			return 'Yesterday';
		
		return date('D, d M Y', $t);
	}
	
    /**
     * Time display in activity view. i.e: Just now, 5 mins ago, 09:32
     */
	public function getTimelineTime() {
		$to_time = time();
		$from_time = strtotime($this->time);
		$sec = abs($to_time - $from_time);
		
		if ($sec < 60) {
			return 'Just now.';
		} elseif ($sec < 3600) {
			$m = round($sec/60);
			return "$m minutes ago.";
		} elseif ($sec < 3600*5) {
			$h = round($sec/3600);
			return "$h hours ago.";
		} else {
			return date('H:i', $from_time);
		}
	}
	
	public function getTimelineNote() {
		return nl2br($this->note);
	}
	
	public function getInputTime() {
		$t = strtotime($this->time);
		if (!$t) return '';
		return date('d/m/Y H:i', $t);
	}
	
	public function setInputTime($value) {
		$this->time = \app\components\Helper::toDbDateTime($value.':00');
	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
		return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('{{%di_tag_act}}', ['activity_id' => 'id']);
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
			ActivityTag::deleteAll('activity_id=:id', [':id'=>$this->id]);
		
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
			
			$at = new ActivityTag([
				'activity_id'=>$this->id,
				'tag_id'=>$tag->id,
			]);
			$at->save();
		}
		
		// delete empty tag
		Tag::deleteAll('id not in (select tag_id from {{%di_tag_act}})');
	}
	
	protected static $_tagListData = null;
	
	public static function getTagListData() {
		if (self::$_tagListData===null) {
			self::$_tagListData = \yii\helpers\ArrayHelper::map(Tag::find()->all(), 'id', 'name');
		}
		return self::$_tagListData;
	}
	
	public function getJsonData() {
		$data = $this->isNewRecord ? [
			'id' => 0,
			'note' => '',
			'inputTime' => date('d/m/Y H:i'),
			'tagValues' => [],
			'income' => null,
			'outcome' => null,
			'title' => 'Create Activity'
		] : [
			'id' => $this->id,
			'note' => $this->note,
			'inputTime' => $this->inputTime,
			'tagValues' => $this->tagValues,
			'income' => $this->income,
			'outcome' => $this->outcome,
			'title' => $this->inputTime
		];
		return json_encode($data);
	}
}
