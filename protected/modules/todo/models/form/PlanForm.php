<?php

namespace todo\models\form;
use todo\models\Task;
use todo\models\Plan;

use Yii;

/**
 * @inheritdoc
 */
class PlanForm extends Plan
{
	/*
	 * @var string Task list in text mode
	 */
	public $taskString;

	/*
	 * @var string sub task is indented by this string
	 */
	protected $_indent = "\t";

	/*
	 * @var Task[] all tasks belong to this plan
	 */
	protected $_allTasks;

	/*
	 * @var Task[] models to render in views
	 */
	public $formTasks = [];

	/*
	 * @var array hierarchy of tasks
	 */
	public $hierarchy = [];
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
		$rules[] = [['description', 'taskString'], 'string'];
		return $rules;
    }

    /**
     * Save task string as multi task records to db
	 * This function is called when saving tasks in text mode
	 * See: todo/plan/update/id/6
     */
	public function saveTaskString() {
		Task::deleteAll('plan_id = :pid', [':pid'=>$this->id]);
		
		$prevTasks = [];
		$order = 10;
		$lines = preg_split("/((\r?\n)|(\r\n?))/", $this->taskString);
		foreach($lines as $line){
			if (!$line) continue;
			
			$task = new Task();
			$task->attributes = $this->_getTaskData($line);
			$task->plan_id = $this->id;
			$task->display_order = $order;
			$level = $this->_countTab($line);
			if (array_key_exists($level-1, $prevTasks)) {
				$parent = $prevTasks[$level-1];
				$task->parent_task_id = $parent->id;
			}
			$task->save();
			
			$prevTasks[$level] = $task;
			$order += 10;
		} 
	}
	
    /**
     * Count how many tab characters at the beginning of string
	 * @param string $s the string to be counted
	 * @return int
     */
	private function _countTab($s) {
		for($i=0; $i<strlen($s); $i++) {
			if ($s[$i] != $this->_indent)	return $i;
		}
		return 0;
	}
	
    /**
     * Parse the string to get task's information
	 * @param string $s the string to be parsed
	 * @return array
     */
	private function _getTaskData($s) {
		$s = str_replace($this->_indent, '', $s);
		$status = strpos($s, '//')===0 ? 
			Task::STATUS_COMPLETE : Task::STATUS_PENDING;
		$name = trim(str_replace('//', '', $s));
		return [
			'name' => $name,
			'status' => $status
		];
	}
	
    /**
     * Convert all task in plan to string.
	 * Each task in a line. Sub task is indent by tab
	 * @return string
     */
	public function generateTaskString() {
		return $this->_buildTaskString($this->rootTasks);
	}
	
	private function _buildTaskString($tasks, $level=0) {
		$result = '';
		/* @var $task Task */
		foreach($tasks as $task) {
			$line = str_repeat($this->_indent, $level);
			if ($task->status==Task::STATUS_COMPLETE)
				$line .= '// ';
			$line .= $task->name . "\r\n";
			$result .= $line;
			$result .= $this->_buildTaskString($task->tasks, $level+1);
		}
		return $result;
	}
	
    /**
     * Import form data to generate task models
	 * @param array $data post array submited from browser
	 *  structure: ['Task'=>[], 'hierarchy' => []]
	 *  if null, models are generated from db
     */
	public function import($data=null) {
		$this->formTasks = [];
		if ($data) {
			if (isset($data['formTasks'])) {
				foreach($data['formTasks'] as $id => $tData) {
					$task = Task::findOne($id) ?: new Task();
					$task->attributes = $tData;
					$this->formTasks[$id] = $task;
				}
				$this->hierarchyJson = $data['hierarchyJson'];
			}
		} else {
			/* generate models from db */
			foreach ($this->tasks as $task) {
				$this->formTasks[$task->id] = $task;
			}
			$this->_createHierarchy($this->hierarchy, $this->_getChildTasks());
		}
	}
	
	public function export() {
		$data = [];
		$data['tree'] = json_encode($this->hierarchy);
		$data['Task'] = [];
		foreach($this->formTasks as $id => $task) {
			$data['Task'][$id] = $task->attributes;
		}
		$data['Plan'] = $this->attributes;
		return $data;
	}
	
	protected function _createHierarchy(&$tree, $tasks) {
		foreach ($tasks as $task) {
			$item = ['id'=>$task->id];
			$childs = $this->_getChildTasks($task->id);
			if ($childs) {
				$item['children'] = [];
				$this->_createHierarchy($item['children'], $childs);
			}
			$tree[] = $item;
		}
	}
	
	protected function _getChildTasks($parent=null) {
		$childs = [];
		foreach ($this->tasks as $task) {
			if ($task->parent_task_id==$parent)
				$childs[]= $task;
		}
		return $childs;
	}
	
	public function saveTasks() {
		// delete tasks
		$ids = array_keys($this->formTasks);
		if ($ids) {
			$s = [];
			foreach ($ids as $id) {
				$s[] = "'$id'";
			}
			$s = implode(',', $s);
			Task::deleteAll("plan_id={$this->id} AND id not IN ({$s})");
		} else {
			Task::deleteAll("plan_id={$this->id}");			
		}
		
		// save new task
		foreach ($this->formTasks as $task) {
			$task->plan_id = $this->id;
			$task->save();
		}
		
		// update parent_task_id
		$this->_setTaskOrder($this->hierarchy);
		foreach ($this->formTasks as $task) {
			$task->save();
		}
	}
	
	protected function _setTaskOrder($tree, &$order=0, $parent=null) {
		foreach ($tree as $item) {
			$order += 10;
			$task = $this->formTasks[$item['id']];
			$task->display_order = $order;
			$task->parent_task_id = $parent;
			if (isset($item['children'])) {
				$this->_setTaskOrder($item['children'], $order, $task->id);
			}
		}
			
	}
	
	public function getHierarchyJson() {
		return json_encode($this->hierarchy);
	}
	
	public function setHierarchyJson($value) {
		$this->hierarchy = json_decode($value, true);
	}
}
