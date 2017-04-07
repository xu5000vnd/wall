<?php

include_once 'config_system.php';


$THEME_NAME = 'wall';
$THEME      = 'wall';
$TABLE_PREFIX = 'wall';

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'theme' => $THEME,
    'language' => 'en',
    // preloading 'log' component
    'preload' => array('log', 'ELangHandler'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.form.*',
        'application.models.base.*',
        'application.models.user.*',
        'application.components.*',
        'application.components.widget.*',
        'application.components.widget.view.*',
        'application.components.BaseFormatter',
        'application.components.helper.*',
        'application.components.smtp.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'application.modules.gii.GiiModule',
            'password' => 'admin1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'application.modules.gii', // a path alias
            ),
        ),
        'admin',
        'member'
    ),
    // application components
    'components' => array(
        // 'session' => array(
        //     'autoStart' => true,
        //     'class' => 'CDbHttpSession',
        //     'timeout' => 11800,
        // ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<action:(error|login|logout)>' => 'site/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<url:(admin|member)>' => '<url>/site/',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ),
            'showScriptName' => false,

        ),
        'db' => array(
            'connectionString' => "mysql:host=$MYSQL_HOSTNAME;dbname=$MYSQL_DATABASE",
            'emulatePrepare' => true,
            'username' => $MYSQL_USERNAME,
            'password' => $MYSQL_PASSWORD,
            'tablePrefix' => $TABLE_PREFIX,
            'charset' => 'utf8',
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels'=>'error, warning, error, info',
                    'categories' => 'system.*',
                    // 'logFile' => 'db.log',
                ),
                [
                    'class' => 'CDbLogRoute',
                    'connectionID' => 'db',
                    'autoCreateLogTable' => false,
                    'logTableName' => $TABLE_PREFIX . "_logger",
                    'levels' => 'info, error'
                ],
                [
                    'class' => 'ext.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters' => [isset($_COOKIE['debug']) ? '127.0.0.1' : '0.0.0.0'],
                ],

            ),
        ),
        'widgetFactory' => array(
            'widgets' => array(
                'XUpload'   => array(
                    'formView'     => 'application.views.layouts.inc.upload_form',
                    'downloadView' => 'application.views.layouts.inc.download_template',
                    'uploadView'   => 'application.views.layouts.inc.upload_template',
                    'options'      => array(
                        'maxFileSize'     => 3 * 1024 * 1024,
                        'acceptFileTypes' => 'js:/\.(jpg|jpeg|png|gif)$/i'
                    )
                ),
            ),
        ),
        'metadata' => array('class' => 'Metadata'),
        'format' => array(
            'class' => 'BaseFormatter'
        ),

        'user'=>array(
            'allowAutoLogin' => true,
            'class' => 'WebUser',
            // this is actually the default value
            'loginUrl'=>array('site/login'),
        ),
        'ePdf' => array(
            'class'         => 'ext.yii-pdf.EYiiPdf',
            'params'        => array(
                'mpdf'     => array(
                    'librarySourcePath' => 'application.vendors.mpdf.*',
                         'constants'         => array(
                         '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                     ),
                    'classFile'=>'mpdf.php', // the literal class filename to be loaded from the vendors folder
                    //'class' => 'mPDF',
                    'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                        'mode'              => '', //  This parameter specifies the mode of the new document.
                        'format'            => 'A4', // format A4, A5, ...
                        'default_font_size' => 0, // Sets the default document font size in points (pt)
                        'default_font'      => '', // Sets the default font-family for the new document.
                        'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                        'mgr'               => 15, // margin_right
                        'mgt'               => 25, // margin_top
                        'mgb'               => 16, // margin_bottom
                        'mgh'               => 0, // margin_header
                        'mgf'               => 9, // margin_footer
                        'orientation'       => 'P', // landscape or portrait orientation
                    )
                ),
            ),
        ),
        'setting' => [
            'class' => 'application.extensions.MyConfig.MyConfig',
            'cacheId' => null,
            'useCache' => false,
            'cacheTime' => 0,
            'tableName' => $TABLE_PREFIX . '_settings',
            'createTable' => false,
            'loadDbItems' => true,
            'serializeValues' => true,
            'configFile' => '',
        ],
    ),
    'aliases'    => array(
      'xupload' => 'application.widgets.xupload'
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
    ),
);
