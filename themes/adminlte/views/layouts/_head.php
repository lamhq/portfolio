<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<meta charset="<?= Yii::$app->charset ?>">
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

<?= Html::csrfMetaTags() ?>
<title><?= Html::encode($this->title) ?> - <?= Html::encode(Yii::$app->name) ?></title>
<?php $this->head() ?>
