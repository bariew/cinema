<?php

$config = [
    'id'        => 'Cinema',
    'basePath'  => dirname(__DIR__),
    'bootstrap' => ['log'],
    'extensions'=> require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'modules'   => [
        'cinema'    => 'app\modules\cinema\Module'
    ],
    'components'=> [
        'urlManager' => [
            'enablePrettyUrl'       => true,
            'showScriptName'        => false,
            'enableStrictParsing'   => true,
            'rules' => [
                // cinema rules
                'api/cinema/<unit_title>/schedule'  => 'cinema/session/index',
                'api/film/<film_title>/schedule'    => 'cinema/session/index',
                'api/session/<id>/places'           => 'cinema/session/view',
                'api/tickets/buy'                   => 'cinema/order/create',
                'api/tickets/reject/<id>'        => 'cinema/order/delete',
                
                ['class' => 'yii\rest\UrlRule', 'controller' => [
                    'cinema/unit', 'cinema/film', 'cinema/hall', 'cinema/session', 'cinema/order', 
                ]],
                // all rules
                '/' => 'site/index',
                '<module>/<controller>/<action>'  => '<module>/<controller>/<action>',
                '<action>' => 'site/<action>',
            ],
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
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
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
        'db' => require(__DIR__ . '/db.php')
    ],
    'params' => require(__DIR__ . '/params.php'),
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
