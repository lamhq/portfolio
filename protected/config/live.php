<?php
ini_set('opcache.enable', false);

$config = \yii\helpers\ArrayHelper::merge(
require(__DIR__ . '/main.php'), [
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=lamhqcom_ma',
			'username' => 'lamhqcom_ma',
			'password' => 'c2h5oh',
		],
	]
]);

return $config;