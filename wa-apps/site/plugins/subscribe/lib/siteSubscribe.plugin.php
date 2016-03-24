<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 08.03.2016
 * Time: 12:18
 */
class siteSubscribePlugin extends waPlugin{
    private static $selfInfo = [
        'id' => 'subscribe',
        'app_id' => 'site'
    ];

    public static function getMainForm(){
        $settings = (new siteInstagramPlugin(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
        $view = wa()->getView();
        $content = $view->fetch('plugins/'.self::$selfInfo['id'].'/templates/main.html');
        return $content;
    }
}