<?php
Yii::setAlias('@backend', realpath(__DIR__.'/../modules/backend'));
Yii::setAlias('@api', realpath(__DIR__.'/../modules/api'));
Yii::setAlias('@portfolio', realpath(__DIR__.'/../modules/portfolio'));

$config = [
	'vendorPath' => realpath(__DIR__ . '/../../vendor'),
	'basePath' => dirname(__DIR__),
	'id' => 'portfolio',
	'name' => 'Lam Huynh\'s Portfolio',
	'timeZone' => 'Asia/Bangkok',
	'language' => 'en-US',
	'sourceLanguage' => 'en-US',
	'defaultRoute' => '/portfolio/project/index',
	
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=portfolio',
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
			'suffix'=>'.html',
			'rules'=>[
				'<id:\d+>/<slug:.*>' => '/portfolio/project/view',
				'tag/<tag:.*>' => '/portfolio/project',
				'' => '/portfolio/project',
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
				'basePath' => '@webroot/themes/oran',
				'baseUrl' => '@web/themes/oran',
				'pathMap' => [
					'@app/views' => '@webroot/themes/oran/views',
				],
			],
		],
		'log' => [
			'targets' => [
				'file' => [
					'class' => 'yii\log\FileTarget',
					'levels' => ['info'],
//					'categories'=> ['application'],
					'categories'=> ['yii\db\*']
				],
			],
		],	
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
		'portfolio'=>[
			'class' => 'portfolio\Module',
		]
    ],
	'params' => [
		'dateFormat' => 'd F Y',	// 23 October 2015
		'pageSize' => 20,
		'ajaxUploadDir' => 'assets/upload',
		'adminEmail' => 'daibanglam@gmail.com',
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
