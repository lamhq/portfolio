<?php
$config = \yii\helpers\ArrayHelper::merge(
require(__DIR__ . '/main.php'), [
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=proper47_blog2',
			'username' => 'proper47_maindb',
			'password' => '6F&irFz??*-n',
		],
	]
]);

return $config;