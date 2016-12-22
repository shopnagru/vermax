<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'defaultRoute' => 'admin/requests',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'B-L73Rj2N__KuNCVGDa00Bw2qKF0b7Ll',
            'baseUrl'=> '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => [
                'user',
                'moderator',
                'admin',
                'superadmin',
            ],
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            //'enableAutoLogin' => true,
        ],
    ],
    'modules' => [
        'debug' => 'yii\debug\Module',
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['192.168.16.220', '192.168.1.242', '192.168.1.252', '192.168.5.155'] // регулируйте в соответствии со своими нуждами
        ],
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'requests',
        ],
        ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',

    ];
    $config['modules']['debug']['allowedIPs'] = ['192.168.16.220', '192.168.1.242', '192.168.1.252', '192.168.5.155'];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',

    ];
    $config['modules']['gii']['allowedIPs'] = ['192.168.16.220', '192.168.1.242', '192.168.1.252', '192.168.5.155'];
}

return $config;
