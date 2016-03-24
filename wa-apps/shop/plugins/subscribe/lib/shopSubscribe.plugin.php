<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 08.03.2016
 * Time: 12:18
 */
class shopSubscribePlugin extends shopPlugin{
    protected static $selfInfo = [
        'id' => 'subscribe',
        'app_id' => 'shop'
    ];

    public static function getMainForm(){
        $settings = (new self(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
        $view = wa()->getView();
        $view->assign('selfInfo',static::$selfInfo);
        return $view->fetch(static::getPluginTemplatePath('main.html'));
    }
}