<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 05.03.2016
 * Time: 21:35
 */

class shopCategoriesPlugin extends shopPlugin{
    protected static $selfInfo = [
        'id' => 'categories',
        'app_id' => 'shop'
    ];
    /**
     * @return mixed
     */
//    PHP7
//    public static function getCats(): string {
    public static function getCats() {
        $settings = (new self(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
        $model = new shopCategoryModel();
        $categories = $model->query('SELECT c.full_url, p.value image
                                        FROM '.$model->getTableName().' c
                                        INNER JOIN '.(new shopCategoryParamsModel())->getTableName().' p ON p.category_id = c.id
                                        WHERE p.name = \'previewImage\'
                                        LIMIT 3')
                            ->fetchAll();
        $view = wa()->getView();
        $view->assign('categories', $categories);
        return $view->fetch(static::getPluginTemplatePath());
    }
}