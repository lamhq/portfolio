<?php

namespace diary\models;
use diary\models\Tag;

use Yii;

/**
 * This is the model class for table "{{%di_plan}}".
 *
 * @property string $id
 * @property integer $year
 * @property integer $month
 * @property integer $tag_id
 * @property string $budget
 *
 * @property DiTag $tag
 */
class Plan extends \yii\db\ActiveRecord
{
    public $outcome;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%di_plan}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['budget'], 'required', 'on'=>['insert', 'update']],
            [['year', 'month', 'tag_id'], 'integer'],
            [['budget'], 'number'],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'year' => 'Year',
            'month' => 'Month',
            'tag_id' => 'Type of Outcome',
            'budget' => 'Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }

	public static function getYearList() {
		$from = date('Y', strtotime('-5 year'));
		$to = date('Y', strtotime('+5 year'));

		// adjust year range with database value
		$row = (new \yii\db\Query())
		->select(['MIN(year) as min', 'MAX(year) as max'])
		->from(self::tableName())
		->one();
		extract($row);	// convert array to $min, $max
		$from = $min ? min($from, $min) : $from;
		$to = max($max, $to);

		$years = range($from, $to);
		return array_combine($years, $years);
	}

	public static function getMonthList() {
		$months = array(
			1=>'January',
			'February',
			'March',
			'April',
			'May',
			'June',
			'July ',
			'August',
			'September',
			'October',
			'November',
			'December',
		);
		return $months;
	}
}
