<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'name' => 'admin CRM',
    'defaultRoute' => 'site/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        'user' => [
                'class' => 'dektrium\user\Module',
                'controllerMap' => [
                    'security' => 'app\controllers\SecurityController',
                  //  'recovery' => 'app\controllers\RecoveryController',
                    'registration' => 'app\controllers\RegistrationController',
                    'settings' => 'app\controllers\SettingsController',
                    'profile' => 'app\controllers\ProfileController'
                ],
                'modelMap' => [
                    'User' => 'app\models\User',
                    'UserSearch' => 'app\models\UserSearch',
                    'Profile' => 'app\models\Profile',
                    'RegistrationForm' => 'app\models\RegistrationForm',
                ],
             //   'admins' => ['MegaAdmin'], // Хардкод для админского пользователя. После настройки прав доступа, нужно удалить эту строку.
            ],
        'users-admin' => [
            'class' => 'mdm\admin\Module',
            // Отключаем шаблон модуля,
            // используем шаблон нашей админки.
            'layout' => null,
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        // Маршруты, открытые по умолчанию всегда.
        // Открываем только для начальной разработки.
        // Как только основные данные о ролях заполнены,
        // убираем отсюда всё лишнее.
        'allowActions' => [
            // Маршруты модуля пользователей.
            // Логин и так разрешён, но разлогиниться 
            // без этой настройки и без настроенных ролей не получится.
            'user/*',
            'security/*',
            'site/*',
            'user/admin/*',
            'users-admin/*',
            'admin/*',
            'letters/*',
            'debug/*',
            'gii/*',
            'statuses/*',
            'positions/*',
            'self/*',
        ]
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'OJLLijAvCpnCV9jzXRfi3XzoPI3Nki_c',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
       /* 'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],*/
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
               'user/login' => 'security/login',
            ],
        ], 
        'authManager' => [
            'class' => 'yii\rbac\DbManager', 
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['192.168.1.16']
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
         'allowedIPs' => ['192.168.1.16']
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
