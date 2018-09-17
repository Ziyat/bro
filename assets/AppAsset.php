<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use dmstr\web\AdminLteAsset;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AdminLteAsset
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
//    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'bower_components/morris.js/morris.css',
        'bower_components/Ionicons/css/ionicons.min.css',
    ];
    public $js = [
        'bower_components/raphael/raphael.min.js',
        'bower_components/morris.js/morris.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
