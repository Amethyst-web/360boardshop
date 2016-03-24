<?php

abstract class shopPlugin extends waPlugin
{
    protected static $selfInfo;

//    PHP7
//    protected static function getStCategoryUrl(array $category) : string{
    protected static function getStCategoryUrl(array $category){
        return wa()->getRouteUrl('/frontend/category', array('category_url' => waRequest::param('url_type') == 1 ? $category['url'] : $category['full_url']));
    }

//    PHP7
//    protected static function getPluginTemplatePath(string $templateName = 'default.html') : string {
    protected static function getPluginTemplatePath($templateName = 'default.html'){
        return 'wa-apps/'.static::$selfInfo['app_id'].'/plugins/'.static::$selfInfo['id'].'/templates/'.$templateName;
    }
}
