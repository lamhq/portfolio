<?php
Yii::setAlias('@backend', realpath(__DIR__.'/../modules/backend'));
Yii::setAlias('@api', realpath(__DIR__.'/../modules/api'));

$config = [
	'vendorPath' => realpath(__DIR__ . '/../../vendor'),
	'basePath' => dirname(__DIR__),
	'id' => 'blog',
	'name' => 'Onehome Blog',
	'timeZone' => 'Asia/Bangkok',
	'language' => 'en-US',
	'sourceLanguage' => 'en-US',
	'defaultRoute' => 'site/index',
	
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=blog',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'blog_',
			'enableSchemaCache' => YII_ENV_PROD,
		],
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules'=>[
				'post/<id:\d+>/<slug:.*>' => 'post/view',
				'category/<id:\d+>/<slug:.*>' => 'category/view',
			]
		],
		'user' => [
			'identityClass' => 'app\models\User',
			'loginUrl' => ['site/login'],
			'enableAutoLogin' => true,
		],
		'authManager' => array(
			'class' => 'yii\rbac\PhpManager',
			'defaultRoles' => array('guest','user')
		),
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'assetManager' => [
			'hashCallback' => function ($path) {
				// make user friendly path
				$s2 = basename($path);
				$s1 = basename(dirname($path));
				return "$s1-$s2";
			}
		],						
		'formatter' => ['class' => 'app\components\Formatter'],
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'daibanglam',
		],
		'view' => [
			'theme' => [
				'basePath' => '@webroot/themes/blog',
				'baseUrl' => '@web/themes/blog',
				'pathMap' => [
					'@app/views' => '@webroot/themes/blog/views',
					'@app/widgets/views' => '@webroot/themes/blog/views/widgets',
					'@app/modules/backend/views' => '@webroot/themes/adminlte/views'
				],
			],
		]
	],
	'modules' => [
		'backend' => [
			'class' => 'backend\Module',
			'accessRules'=>[
				[
					'allow' => true,
					'controllers' => ['backend/site'],
					'actions' => ['login', 'error'],
					'roles' => ['?'],
				],
				[
					'allow' => true,
					'roles' => ['@'],
				],
				[
					'allow' => false,
					'roles' => ['?'],
				],
			]
		],
		'api' => [
            'class' => 'api\Module',
        ],
		'redactor' => [
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@webroot/media/wyswyg',
            'uploadUrl' => '@web/media/wyswyg',
            'imageAllowExtensions'=>['jpg','png','gif']
        ],
    ],
	'params' => [
		'dateFormat' => 'd F Y',	// 23 October 2015
		'pageSize' => 20,
		'ajaxUploadDir' => 'assets/upload'
	],
];

if (YII_DEBUG) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
