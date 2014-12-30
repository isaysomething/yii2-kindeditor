<?php

namespace yrssoft\kindeditor;

use yii\web\View;

/**
 * This is just an example.
 */
class Kindeditor extends \yii\base\Widget {

    /**
     *
     * @var type 编辑器的ID
     */
    public $editorId = 'content-editor';

    public function run() {
        $script = <<<EOF
KindEditor.ready(function(K) {
    window.editor = K.create('#{$this->editorId}');
});
EOF;
        $this->getView()->registerJs($script, View::POS_END);
        // 发布资源到 assets 目录
        KindeditorAsset::register($this->getView());
    }

}
