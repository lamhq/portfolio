<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="page-title heading">Contact</h1>
<p class="text-right"><em>If you need my help or just saying hello is welcome :)</em></p>

<div class="row">
	<div class="col-md-6">
		<section class="contact-form">
			<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

				<?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

				<?= $form->field($model, 'email') ?>

				<?= $form->field($model, 'subject') ?>

				<?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>

				<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
					'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
				]) ?>

				<div class="form-group">
					<?= Html::submitButton('Send', ['class' => 'btn btn-port']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</section>
	</div>
	
	<div class="col-md-6">
		<section class="contact-info">
		<h2>Contact Information</h2>
		<p>
			<i class="fa fa-home"></i>649/58/56 Dien Bien Phu, Binh Thanh District, Ho Chi Minh, Vietnam.
		</p>
		<p>
			<i class="fa fa-skype"></i>hqlam90
		</p>
		<p>
			<i class="fa fa-envelope"></i><a href="mailto:hqlam.bt@gmail.com">hqlam.bt@gmail.com</a>
		</p>
		<p>
			<i class="fa fa-phone"></i>+84 165 613 2637
		</p>
		</section>
	</div>
</div>
