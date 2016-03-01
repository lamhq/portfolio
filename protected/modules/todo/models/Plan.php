<?php

namespace todo\models;

use Yii;

/**
 * This is the model class for table "my_td_plan".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $status
 *
 * @property Task[] $tasks
 * @property Task[] $rootTasks
 */
class Plan extends \yii\db\ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_ARCHIVED = 0;

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_td_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'taskString'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['plan_id' => 'id'])
			->orderBy('display_order');
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRootTasks()
    {
        return $this->hasMany(Task::className(), ['plan_id' => 'id'])
			->where([
				'parent_task_id' => null
			]);
    }
	
	public function archive() {
		$this->status = self::STATUS_ARCHIVED;
		$this->save();
	}
	
	public function getCompletedCount() {
		$query = Task::find()
			->from(Task::tableName(). ' t')
			->joinWith('tasks')
			->andFilterWhere(['t.plan_id' => $this->id])
			->andWhere(['child.parent_task_id' => null])
			->andFilterWhere(['t.status' => Task::STATUS_COMPLETE]);

		return $query->count();
	}
	
	public function getTotalCount() {
		$query = Task::find()
			->from(Task::tableName(). ' t')
			->joinWith('tasks')
			->andWhere(['child.parent_task_id' => null])
			->andFilterWhere(['t.plan_id' => $this->id]);

		return $query->count();
	}
}
