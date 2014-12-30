<?php

namespace yrssoft\kindeditor;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Description of KindeditorAsset
 *
 * @author yrssoft
 */
class KindeditorAsset extends AssetBundle {

    public $jsOptions = ['position' => View::POS_HEAD];
    public $sourcePath = '@vendor/yrssoft/yii2-kindeditor/assets/';
    public $js = [
        'kindeditor.js',
        '/lang/zh_CN.js',
    ];
    public $css = [
        'themes/default/default.css',
    ];

}
