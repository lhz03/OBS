<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 复制管理
 *
 * @package CopyManage
 * @author alanyuewei
 * @version 1.0.0
 * @link https://www.wjssk.com
 */
class CopyManage_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->footer = array('CopyManage_Plugin', 'render');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        // 开关
        $url_status = new Typecho_Widget_Helper_Form_Element_Radio('url_status',
            [1 => _t('开启'), 0 => _t('关闭')], 1, _t('是否显示当前连接'), _t('原文链接：https://www.wjssk.com'));
        $form->addInput($url_status);
        // 添加在复制文本后面的文字
        $info = new Typecho_Widget_Helper_Form_Element_Text('info', NULL, '转载请附上原文出处链接及本声明。', _t('复制备注'), _t('添加在复制文本后面的文字'));
        $form->addInput($info);
        // 过滤哪些元素
        $info = new Typecho_Widget_Helper_Form_Element_Checkbox('filter_box', ['INPUT' => _t('输入框(input)'), 'TEXTAREA' => _t('文本域(textarea)')], '', _t('设置在哪些元素上静止生效'), _t('设置在哪些元素上静止生效，比如文本框(input)，写了一点，需要复制一段，就尴尬了'));
        $form->addInput($info);
        // 是否应用layer.js
        $has_layer = new Typecho_Widget_Helper_Form_Element_Checkbox('has_layer', [1 => '是否加载layer.js(弹窗jswen文件)'], 1);
        $form->addInput($has_layer);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     */
    public static function render()
    {
        $get_form = Typecho_Widget::widget('Widget_Options')->plugin('CopyManage');
        if ($get_form->has_layer) {
            echo '<script src="https://www.layuicdn.com/layer/layer.js"></script>';
        }
        $return = '<script>';
        $return .= 'var filter_box = ' . json_encode($get_form->filter_box) . ';';
        $return .= 'document.body.oncopy = function (e){';
        $return .= 'if(filter_box.includes(e.target.nodeName)){return false;}';
        $return .= 'var copy_text = e.srcElement?e.srcElement.innerHTML:e.target.innerHTML;';
        $return .= 'copy_text += "\r\n------------\r\n' . $get_form->info . '";';
        if ($get_form->url_status) {
            $return .= 'copy_text += "\r\n原文链接："+location.href;';
        }
        $return .= 'e.preventDefault();';
        $return .= 'e.clipboardData.setData("text",copy_text);';
        $return .= 'layer.msg("' . $get_form->info . '",function (){});';
        $return .= '}';
        $return .= '</script>';

        echo $return;
    }
}
