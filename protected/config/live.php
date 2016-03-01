<?php
$config = \yii\helpers\ArrayHelper::merge(
require(__DIR__ . '/web.php'), [
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=lamhqcom_myapp',
			'username' => 'lamhqcom_myapp',
			'password' => 'q@(_i)NlaSd-',
			'tablePrefix' => 'my_',
		],
	]
]);

return $config;