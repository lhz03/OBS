<?php
/**
 * HotUpdate 是基于Joe主题的一款热更新插件
 * 
 * @package HotUpdate
 * @author 黄小嘻
 * @link https://www.kuckji.cn
 * @version 1.0.0
 */
require_once __DIR__ . '/assets/Depend.php';
class HotUpdate_Plugin implements Typecho_Plugin_Interface
{
    public static $panel = 'HotUpdate/Page/InspectPage.php';
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * subscriber
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate(){
        Helper::addPanel(1, static::$panel, _t('Joe版本管理'), _t('Joe在线升级'), 'subscriber');
        // HotUpdate_Plugin::update();
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){
        Helper::removePanel(1, static::$panel);
    }
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
        $Hot_auto_update = new Typecho_Widget_Helper_Form_Element_Radio(
            'Hot_auto_update', array(
                "auto_yes" => "开启", 
                "auto_no" => "关闭"
            ),"auto_yes",_t('是否自动升级'),"如果开启，将在管理员登录后台时自动获取Joe主题是否为最新版本并升级（默认开启）该功能暂未开放！");
        $form->addInput($Hot_auto_update);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render(){}

    /**
     * 前端页面显示方法
     * 
     * @access public
     * @return void
     */
    public static function show(){}
}

