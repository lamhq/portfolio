<?php
/* @var $this yii\web\View */
/* @var $model diary\models\Activity */
if ($model->hasErrors()) {
	$this->registerJs('$("#act-modal").modal({ show: true });');
}
?>
<div class="modal" id="act-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Create or Update Activity</h4>
			</div>
			
			<div class="modal-body">
				<?= $this->render('_form', ['model'=>$model]) ?>
			</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->