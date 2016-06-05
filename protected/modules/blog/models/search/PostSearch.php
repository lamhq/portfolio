<?php

namespace blog\models\search;

use Yii;
use yii\base\Model;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use blog\models\Post;
use blog\models\PostTag;
use blog\models\Tag;

/**
 * PostSearch represents the model behind the search form about `blog\models\Post`.
 */
class PostSearch extends Post
{
	public $key, $searchTags;
	
	public $minRating;
	
	public $sort ='updated_time';
	
	public $dir = 'desc';
	
	public static $SORT_BY = [
		'rating' => 'Rating',
		'updated_time' => 'Date'
	];
	
	public static $DIRECTIONS = [
		'asc' => 'Ascending',
		'desc' => 'Descending',
	];
	
	/* @var Post[] */
	public $models = [];
	
	/* @var Pagination */
	public $pagination;
	
	/* @var \yii\db\ActiveQuery */
	public $query;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'rating', 'minRating'], 'integer'],
            [['title', 'content', 'created_time', 'updated_time'], 'safe'],
            [['sort', 'dir'], 'required', 'on'=>'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
		// bypass scenarios() implementation in the parent class
		$scenarios = Model::scenarios();
		$scenarios['search'] = ['key','minRating', 'searchTags', 'sort','dir'];
		return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'minRating' => 'Min Rating',
            'searchTags' => 'Tag',
            'sort' => 'Sort by',
            'dir' => 'Direction',
        ];
    }
	
	/**
	 * Set query param and prepare data
	 */
	public function search($params) {
		$this->query = $query = Post::find()
			->from(self::tableName(). ' p')
			->with('tags');
		
		if ($this->load($params) && $this->validate()) {
			$filters = [
				new \blog\components\ContentFilter(),
				new \blog\components\RatingFilter(),
				new \blog\components\TagFilter(),
			];
		
			foreach($filters as $filter) {
				$filter->apply($query, $this);
			}
			
		}
		
		// create a pagination object with the total count
		$pagination = $this->pagination = new Pagination([
			'totalCount' => $query->count(),
			'defaultPageSize' => 10
		]);

		$query->orderBy($this->sort.' '.$this->dir);
		// limit the query using the pagination and retrieve the post
		$this->models = $query->offset($pagination->offset)
			->limit($pagination->limit)
			->all();
	}
	
	/*
	 * get available tags in current posts
	 */
	public function getTagListData() {
		$tagQuery = Tag::find()
			->from(Tag::tableName(). ' t')
			->orderBy('name');
		
		if (!$this->models)
			return ArrayHelper::map($tagQuery->all(), 'id', 'name');
		
		// get the sql of post filtering
		$q = clone $this->query;
		$q->limit(null)->offset(null)->orderBy(null)->select('p.id');
		$data = \yii::$app->db->queryBuilder->build($q);
		$sql = $data[0];
		$params = isset($data[1]) ? $data[1] : [];
		
		// find available tags for available posts
		$tagQuery->innerJoin(PostTag::tableName().' pt', 't.id=pt.tag_id')
			->andWhere("pt.post_id IN ($sql)")
			->params($params);
		return ArrayHelper::map($tagQuery->all(), 'id', 'name');
	}
}
