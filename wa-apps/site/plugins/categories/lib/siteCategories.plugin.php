<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 05.03.2016
 * Time: 21:35
 */
require '/wa-apps/shop/lib/model/shopCategory.model.php';
require '/wa-apps/shop/lib/model/shopCategoryParams.model.php';

class siteCategoriesPlugin extends waPlugin{
    private static $selfInfo = [
        'id' => 'categories',
        'app_id' => 'site'
    ];
    /**
     * @return mixed
     */
    public static function getCats(): string {
        $settings = (new siteInstagramPlugin(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
        $model = new shopCategoryModel();
        $categories = $model->query('SELECT c.full_url, p.value image
                                        FROM '.$model->getTableName().' c
                                        INNER JOIN '.(new shopCategoryParamsModel())->getTableName().' p ON p.category_id = c.id
                                        WHERE p.name = \'previewImage\'
                                        LIMIT 4')
                            ->fetchAll();
        $view = wa()->getView();
        $view->assign('categories', $categories);
        $content = $view->fetch('plugins/'.self::$selfInfo['id'].'/templates/default.html');
        return $content;
    }
}