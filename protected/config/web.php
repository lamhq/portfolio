<?php
Yii::setAlias('@todo', realpath(__DIR__.'/../modules/todo'));
Yii::setAlias('@diary', realpath(__DIR__.'/../modules/diary'));
Yii::setAlias('@blog', realpath(__DIR__.'/../modules/blog'));
Yii::setAlias('@freelance', realpath(__DIR__.'/../modules/freelance'));

$config = [
	'vendorPath' => realpath(__DIR__ . '/../../vendor'),
	'basePath' => dirname(__DIR__),
	'id' => 'myapp',
	'name' => 'My App',
	'timeZone' => 'Asia/Bangkok',
	'language' => 'en-US',
	'sourceLanguage' => 'en-US',
	'defaultRoute' => 'diary/activity',
	
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=myapp',
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'my_',
			'enableSchemaCache' => YII_ENV_PROD,
		],
		'urlManager' => [
			'class' => 'yii\web\UrlManager',
			'enablePrettyUrl' => true,
			'showScriptName' => false
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
			'bundles' => YII_ENV_PROD ? require(__DIR__ . '/_assets-prod.php') : [],
			'hashCallback' => function ($path) {
				// make user friendly path
				$s2 = basename($path);
				$s1 = basename(dirname($path));
				return "$s1-$s2";
			}
		],						
		'helper' => ['class' => 'app\components\Helper'],
		'formatter' => ['class' => 'app\components\Formatter'],
		'request' => [
			// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
			'cookieValidationKey' => 'daibanglam',
		],
	],
    'as globalAccess'=>[
        'class'=>'app\behaviors\GlobalAccessBehavior',
        'rules'=>[
			// guest can login and see error page
			[
                'allow' => true,
                'controllers'=>['site'],
				'actions' => ['login', 'error'],
				'roles' => ['?'],
			],
			
			// user can only change their profile
			[
                'allow' => true,
                'controllers'=>['site'],
				'roles' => ['@'],
			],
			
			// admin can do any thing
			[
                'allow' => true,
				'roles' => ['admin'],
			],
        ],
    ],
	'modules' => [
		'todo' => ['class' => 'todo\Module'],
		'diary' => ['class' => 'diary\Module'],
		'blog' => ['class' => 'blog\Module'],
		'freelance' => ['class' => 'freelance\Module'],
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
		'site_title' => 'My app',
		'theme_skin' => 'skin-blue',
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
