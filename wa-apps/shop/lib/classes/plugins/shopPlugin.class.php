<?php

abstract class shopPlugin extends waPlugin
{
    protected static $selfInfo;

    protected static function getStCategoryUrl(array $category) : string{
        return wa()->getRouteUrl('/frontend/category', array('category_url' => waRequest::param('url_type') == 1 ? $category['url'] : $category['full_url']));
    }

    protected static function getPluginTemplatePath(string $templateName = 'default.html') : string {
        return 'wa-apps/'.static::$selfInfo['app_id'].'/plugins/'.static::$selfInfo['id'].'/templates/'.$templateName;
    }
}
