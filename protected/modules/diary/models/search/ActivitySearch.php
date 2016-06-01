<?php

namespace diary\models\search;

use Yii;
use yii\base\Model;
use yii\data\Pagination;
use diary\models\Activity;

/**
 * ActivitySearch represents the model behind the search form about `diary\models\Activity`.
 */
class ActivitySearch extends Activity {

	public $key, $dateRange, $searchTags, $fromDate, $toDate;
	
	/* @var Activity[] */
	public $models = [];
	
	/* @var Pagination */
	public $pagination;
	
	/* @var yii\db\ActiveQuery */
	public $query;
	
	static public $DATE_RANGE_LIST = [
		'all' => 'All',
		'7days' => 'Latest 7 days',
		'month' => 'Current month',
		'last-month' => 'Last month',
		'year' => 'Current year',
		'custom' => 'Custom',
	];

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['key', 'dateRange', 'searchTags', 'fromDate', 'toDate'], 'safe', 'on'=>'search'],
		];
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
			'searchTags' => 'Tag'
        ];
    }
	/**
	 * @inheritdoc
	 */
	public function scenarios() {
		// bypass scenarios() implementation in the parent class
		$scenarios = Model::scenarios();
		$scenarios['search'] = ['key','dateRange','searchTags', 'fromDate', 'toDate'];
		return $scenarios;
	}

	/**
	 * Set query param and prepare data
	 */
	public function search($params) {
		$query = Activity::find();
		$query->with('tags');
		
		if ($this->load($params) && $this->validate()) {
			if ($this->key)
				$query->andFilterWhere(['like', 'note', $this->key]);
			
			$from = '1970-01-01';
			$to = '2999-01-01';
			switch ($this->dateRange) {
				case '7days':
					$from = date('Y-m-d', strtotime("-7 day"));
					$to = date('Y-m-d 23:59:59');
					break;
				case 'month':
					$from = date('Y-m-01');
					$to = date('Y-m-t 23:59:59');
					break;
				case 'last-month':
					$from = date("Y-m-01", strtotime("-1 month"));
					$to = date('Y-m-t 23:59:59', strtotime("-1 month"));
					break;
				case 'year':
					$from = date('Y-01-01');
					$to = date('Y-12-t 23:59:59');
					break;
				case 'custom':
					$from = \app\components\Helper::toDbDate($this->fromDate);
					$to = \app\components\Helper::toDbDate($this->toDate).' 23:59';
					break;
			}
			$query->andFilterWhere(['>=', 'time', $from])
				->andFilterWhere(['<=', 'time', $to]);
			
			if ($this->searchTags && $tags = implode(',', $this->searchTags)) {
				$query
					->from(self::tableName(). ' act')
					->innerJoin('{{%di_tag_act}} ta', 'act.id = ta.activity_id')
					->andWhere(sprintf("ta.tag_id IN (%s)", $tags));
			}
				
		}
		
		// create a pagination object with the total count
		$pagination = $this->pagination = new Pagination([
			'totalCount' => $query->count(),
			'defaultPageSize' => 7
		]);

		$query->orderBy('`time` DESC');
		$this->query = clone $query;
		// limit the query using the pagination and retrieve the articles
		$this->models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();
	}
	
}
