<?php

namespace todo\models;

use Yii;

/**
 * This is the model class for table "my_td_task".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property string $completed_time
 * @property integer $display_order
 * @property integer $parent_task_id
 * @property integer $plan_id
 *
 * @property TdPlan $plan
 * @property Task $parentTask
 * @property Task[] $tasks
 */
class Task extends \yii\db\ActiveRecord
{
    const STATUS_COMPLETE = 1;
    const STATUS_PENDING = 0;
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_td_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'display_order', 'parent_task_id', 'plan_id'], 'integer'],
            [['completed_time'], 'string'],
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
            'status' => 'Status',
            'display_order' => 'Display Order',
            'parent_task_id' => 'Parent Task ID',
            'plan_id' => 'Plan ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
        return $this->hasOne(TdPlan::className(), ['id' => 'plan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'parent_task_id'])
			->orderBy('display_order');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['parent_task_id' => 'id'])
			->from(self::tableName(). ' child')
			->orderBy('child.display_order');
    }
}
