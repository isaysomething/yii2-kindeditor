<?php

namespace yrssoft\kindeditor;

use Yii;
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
    public $width; // 编辑器的宽度
    public $height; // 编辑器的高度
    public $minWidth = 650; // 编辑器的最小宽度
    public $minHeight = 100; // 编辑器的最小高度
    public $items = [
        'source', '|', 'undo', 'redo', '|', 'preview', 'print', 'template', 'code', 'cut', 'copy', 'paste',
        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
        'anchor', 'link', 'unlink', '|', 'about'
    ]; // 编辑器的工具栏
    public $resizeType = 2; // 编辑器高、宽拖动，2或1或0，2时可以拖动改变宽度和高度，1时只能改变高度，0时不能拖动。
    public $themeType = 'default'; // 指定主题风格，可设置”default”、”simple”，指定simple时需要引入simple.css。
    public $langType = 'zh_CN'; // 指定语言，可设置”en”、”zh_CN”，需要引入lang/[langType].js。
    public $designMode = TRUE; // Boolean，可视化模式或代码模式。默认：可视化模式
    public $fullscreenMode = FALSE; //true时加载编辑器后变成全屏模式
    public $basePath; // 指定编辑器的根目录路径
    public $themePath; // 指定编辑器的themes目录路径
    public $pluginsPath; // 指定编辑器的plugins目录路径
    public $langPath; // 指定编辑器的lang目录路径
    public $minChangeSize = 5; // undo/redo文字输入最小变化长度，当输入的文字变化小于这个长度时不会添加到undo记录里。
    public $urlType = ''; // 改变站内本地URL，可设置”“、”relative”、”absolute”、”domain”。空为不修改URL，relative为相对路径，absolute为绝对路径，domain为带域名的绝对路径。
    public $newlineTag = 'p'; // 设置回车换行标签，可设置”p”、”br”。
    public $pasteType = 2; // 设置粘贴类型，0:禁止粘贴, 1:纯文本粘贴, 2:HTML粘贴 
    public $dialogAlignType = 'page'; // 设置弹出框(dialog)的对齐类型，可设置”“、”page”，指定page时按当前页面居中，指定空时按编辑器居中。
    public $shadowMode = TRUE; // true时弹出层(dialog)显示阴影。
    public $zIndex = 811213; // 指定弹出层的基准z-index。
    public $useContextmenu = TRUE; // true时使用右键菜单，false时屏蔽右键菜单。
    public $syncType = 'form'; // 同步数据的方式，可设置”“、”form”，值为form时提交form时自动同步，空时不会自动同步。
    public $cssPath = ''; // 指定编辑器iframe document的CSS文件，用于设置可视化区域的样式。
    public $cssData = ''; // 指定编辑器iframe document的CSS数据，用于设置可视化区域的样式。
    public $bodyClass = 'ke-content'; // 指定编辑器iframe document body的className。
    // 指定取色器里的颜色。
    public $colorTable = [
        ['#E53333', '#E56600', '#FF9900', '#64451D', '#DFC5A4', '#FFE500'],
        ['#009900', '#006600', '#99BB00', '#B8D100', '#60D978', '#00D5FF'],
        ['#337FE5', '#003399', '#4C33E5', '#9933E5', '#CC33E5', '#EE33EE'],
        ['#FFFFFF', '#CCCCCC', '#999999', '#666666', '#333333', '#000000']
    ];
    public $afterCreate; // 设置编辑器创建后执行的回调函数
    public $afterChange; // 编辑器内容发生变化后执行的回调函数
    public $afterTab; // 按下TAB键后执行的的回调函数。默认值: 插入4个空格的函数
    public $afterFocus; // 编辑器聚焦(focus)时执行的回调函数
    public $afterBlur; // 编辑器失去焦点(blur)时执行的回调函数
    public $afterUpload; // 上传文件后执行的回调函数
    public $uploadJson; // 指定上传文件的服务器端程序。默认：basePath + ‘php/upload_json.php’
    public $fileManagerJson; // 指定浏览远程图片的服务器端程序。默认值: basePath + ‘php/file_manager_json.php’
    public $allowPreviewEmoticons = TRUE; // true时鼠标放在表情上可以预览表情。
    public $allowImageUpload = TRUE; // true时显示图片上传按钮。
    public $allowFlashUpload = TRUE; // true时显示Flash上传按钮。
    public $allowMediaUpload = TRUE; // true时显示视音频上传按钮。
    public $allowFileUpload = TRUE; // true时显示文件上传按钮。 
    public $allowFileManager = TRUE; // true时显示浏览远程服务器按钮。
    public $fontSizeTable = ['9px', '10px', '12px', '14px', '16px', '18px', '24px', '32px']; // 指定文字大小。
    public $imageTabIndex = 0; // 图片弹出层的默认显示标签索引。
    public $formatUploadUrl = TRUE; // false时不会自动格式化上传后的URL。
    public $fullscreenShortcut = TRUE; // false时禁用ESC全屏快捷键。
    public $extraFileUploadParams; // Array 上传图片、Flash、视音频、文件时，支持添加别的参数一并传到服务器。
    public $filePostName = 'imgFile'; // 指定上传文件form名称。
    public $fillDescAfterUploadImage = FALSE; // true时图片上传成功后切换到图片编辑标签，false时插入图片后关闭弹出框。
    public $afterSelectFile; // 从图片空间选择文件后执行的回调函数。
    public $pagebreakHtml = '<hr style=”page-break-after: always;” class=”ke-pagebreak” />'; // 可指定分页符HTML
    public $allowImageRemote = TRUE; // true时显示网络图片标签，false时不显示。
    public $autoHeightMode = FALSE; // 值为true，并引入autoheight.js插件时自动调整高度。
    private $arguments = [
        'width', 'height', 'minWidth', 'minHeight',
        'uploadJson'
    ]; // 编辑器初始化参数
    private $functions = []; // 编辑器函数

    public function run() {
        if(empty($this->uploadJson)) {
            $this->uploadJson = \yii\helpers\Url::toRoute(['/file/upload']);
        }
        // 获取编辑器初始化参数
        $initParams = $this->initEditor();
        $script = <<<EOF
KindEditor.ready(function(K) {
    window.editor = K.create('#{$this->editorId}',$initParams);
});
EOF;
        $this->getView()->registerJs($script, View::POS_END);
// 发布资源到 assets 目录
        KindeditorAsset::register($this->getView());
    }

    private function initEditor() {
        $jsonData = '{';
        $jsonData .= $this->setEditorArguments();
        $jsonData .= $this->setEditorFunctions();
        return $jsonData . '}';
    }

    /**
     * 设置编辑器参数
     */
    private function setEditorArguments() {
        $arguments = '';
        foreach ($this->arguments as $value) {
            if (!empty($this->$value)) {
                $arguments .= "{$value} : '{$this->$value}',";
            }
        }
        $arguments = substr($arguments, 0, -1);
        return $arguments;
    }

    /**
     * 设置编辑器回调函数
     */
    private function setEditorFunctions() {
        foreach ($this->functions as $value) {
            if (!empty($this->$value)) {
            }
        }
    }

}
