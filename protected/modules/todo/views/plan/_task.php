<?php
/* @var $item array */
/* @var $model todo\models\form\PlanForm */
use yii\helpers\Html;
use todo\models\Task;
$task = array_key_exists($item['id'], $model->formTasks) ?
	$model->formTasks[$item['id']] :
	new Task(['name'=>'New task']);
?>
<li class="dd-item" data-id="<?= $item['id'] ?>">
	<div class="dd-handle">
		<i class="fa fa-ellipsis-v"></i>
		<i class="fa fa-ellipsis-v"></i>
	</div>
	<div class="dd-content">
		<?= Html::checkbox("PlanForm[formTasks][{$item['id']}][status]", 
			$task->status==Task::STATUS_COMPLETE, ['uncheck'=>0]) ?>

		<span class="editable-text name"><?= $task->name ?></span>

		<?= Html::activeTextInput($task, 'name', 
			['name'=>"PlanForm[formTasks][{$item['id']}][name]", 'class'=>'editable-input']); ?>
		
		<?= Html::activeHiddenInput($task, 'completed_time', 
			['name'=>"PlanForm[formTasks][{$item['id']}][completed_time]", 'class'=>'completed-time']); ?>
		
		<div class="tools">
			<i class="fa fa-trash-o btn-remv-task" title="Remove"></i>
		</div>
	</div>

	<?php if (isset($item['children'])): ?>
		<ol class="dd-list">
		<?php foreach($item['children'] as $child) :?>
			<?= $this->render('_task', [
				'model' => $model, 
				'item' => $child,
			]) ?>
		<?php endforeach; ?>		
		</ol>
	<?php endif ?>
</li>
