<?php
/* @var $this yii\web\View */
/* @var $model diary\models\Plan */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

if ($model->hasErrors()) {
	$this->registerJs('$("#update-modal").modal({ show: true });');
}
?>
<div class="modal" id="update-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Update</h4>
			</div>
			
			<div class="modal-body">
			<?php $form = ActiveForm::begin(); ?>
				<?= Html::activeHiddenInput($model, 'id') ?>
				<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
				<?php echo $form->field($model, 'description')->widget(
					\yii\imperavi\Widget::className(),
					[
						'plugins' => ['fullscreen'],
						'options' => [
							'minHeight' => 400,
							'maxHeight' => 400,
							'buttonSource' => true,
							'convertDivs' => false,
							'removeEmptyTags' => true,
						]
					]
				) ?>
				<div class="form-group">
					<button class="btn btn-success" type="submit">Save</button>
				</div>
			<?php ActiveForm::end(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->