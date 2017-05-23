<?php
Yii::setAlias('@backend', realpath(__DIR__.'/../modules/backend'));
Yii::setAlias('@diary', realpath(__DIR__.'/../modules/diary'));
Yii::setAlias('@note', realpath(__DIR__.'/../modules/note'));
Yii::setAlias('@portfolio', realpath(__DIR__.'/../modules/portfolio'));

$config = [
	'vendorPath' => realpath(__DIR__ . '/../../vendor'),
	'basePath' => dirname(__DIR__),
	'id' => 'portfolio',
	'name' => 'Lam Huynh - PHP Web Developer',
	'timeZone' => 'Asia/Bangkok',
	'language' => 'en-US',
	'sourceLanguage' => 'en-US',
	'defaultRoute' => '/portfolio/project/index',
	
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=portfolio',
			'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
			'tablePrefix' => 'my_',
			'enableSchemaCache' => YII_ENV_PROD,
		],
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules'=>[
				// portfolio module
				'portfolio/project/<id:\d+>/<slug:.*>.html' => '/portfolio/project/view',
				'portfolio/tag/<tag:.*>.html' => '/portfolio/project',
				'' => '/portfolio/project',
				
				// blog module
				'page/<id:\d+>/<slug:.*>.html' => '/page/view',
				'blog/post/<id:\d+>/<slug:.*>.html' => 'blog/post',
				'blog/category/<id:\d+>/<slug:.*>.html' => 'blog/category',
				'blog/tag/<slug:.*>.html' => 'blog/tag',
				
				// frequently access link
				'd' => '/diary/activity',
				'p' => '/diary/plan/index',
				'p/s' => '/diary/plan/save',
				'p/f' => '/diary/plan/form',
				'n' => '/note/post',
				'n/a' => '/note/post/create',
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
		'backend' => [ 'class' => 'backend\Module' ],
		'diary' => ['class' => 'diary\Module' ],
		'note' => ['class' => 'note\Module' ],
		'portfolio'=>['class' => 'portfolio\Module' ],
		'redactor' => [
			'class' => 'yii\redactor\RedactorModule',
			'uploadDir' => '@webroot/media/wyswyg',
			'uploadUrl' => '@web/media/wyswyg',
			'imageAllowExtensions'=>['jpg','png','gif']
		],
		'markdown' => [
			// the module class
			'class' => 'kartik\markdown\Module',

			// the controller action route used for markdown editor preview
			'previewAction' => '/markdown/parse/preview',

			// the list of custom conversion patterns for post processing
			'customConversion' => [
				'<table>' => '<table class="table table-bordered table-striped">'
			],

			// whether to use PHP SmartyPantsTypographer to process Markdown output
			'smartyPants' => true
		]
	],
	'params' => [
		'dateFormat' => 'd F Y',	// 23 October 2015
		'pageSize' => 20,
		'ajaxUploadDir' => 'assets/upload',
		'adminEmail' => 'daibanglam@gmail.com',
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
];

if (YII_DEBUG) {
	// configuration adjustments for 'dev' environment
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = 'yii\debug\Module';

	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
