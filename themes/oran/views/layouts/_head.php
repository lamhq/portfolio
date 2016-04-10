<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>
<head>
	<meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="SKYPE_TOOLBAR" content ="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <meta name="description" content="" />
    <meta name="author" content="" />
	<link rel="shortcut icon" href="<?= $this->theme->baseUrl ?>/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="<?= $this->theme->baseUrl ?>/favicon.ico" type="image/x-icon" />

	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?> - <?= Html::encode(Yii::$app->name) ?></title>
	<?php $this->head() ?>
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>