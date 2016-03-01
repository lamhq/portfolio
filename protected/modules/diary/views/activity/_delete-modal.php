<?php
/* @var $form yii\widgets\ActiveForm */
use yii\widgets\ActiveForm;
?>
<div class="modal" id="del-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Delete</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure to delete this activity?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
				
				<?php $form = ActiveForm::begin(); ?>
				<input type="hidden" name="delete" class="act-id" />
				<button type="submit" class="btn btn-primary">Delete</button>
				<?php ActiveForm::end(); ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->