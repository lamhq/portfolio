<?php

namespace todo\models\search;

use Yii;
use yii\base\Model;
use todo\models\Plan;

/**
 * PlanSearch represents the model behind the search form about `todo\models\Plan`.
 */
class PlanSearch extends Plan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return Plan[]
     */
    public function search($params=array())
    {
        $query = Plan::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return array();
        }

        $query->andFilterWhere([
            'id' => $this->id,
       ]);

        $query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['status' => self::STATUS_ACTIVE])
            ->andFilterWhere(['like', 'description', $this->description]);

		$models = [];
		foreach($query->all() as $model) {
			$models[$model->id] = $model;
		}
		return $models;
    }
}
