<?php
/**
 * @var $this yii\web\View
 * @var $model app\models\Subscriber
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<section class="subscribe-form">
	<h3>Subscribe to us!</h3>
	<p>We promise not to rent, share or spam your account, ever. Read our privacy policy here.</p>
	<?php 
	$form = ActiveForm::begin();
	$field = $form->field($model, 'email')->textInput(['class'=>'form-control', 'placeholder'=>'your email']);
	?>
		<div class="input-group">
			<?php $field->template = "{input}"; echo $field; ?>
			<span class="input-group-btn"><button type="submit" class="btn-2">Subscribe</button></span>
		</div>
		<?php $field->template = "{error}"; echo $field; ?>
	<?php ActiveForm::end() ?>
	<p>You can also stay updated by following us below</p>
	<ul class="socials">
		<li><a href="https://www.facebook.com/sgonehomeproperty" class="icon-facebook">facebook</a></li>
		<li><a href="#" class="icon-twitter">twitter</a></li>
	</ul>
</section>