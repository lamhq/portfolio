<?php
/* @var $this yii\web\View */
/* @var $model diary\models\Activity */
if ($model->hasErrors()) {
	$this->registerJs('$("#updateModal'.$model->id.'").modal({ show: true });');
}
?>
<div class="modal" id="updateModal<?= $model->id ?>">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Update activity</h4>
			</div>
			
			<div class="modal-body">
				<?= $this->render('_form', ['model'=>$model]) ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->