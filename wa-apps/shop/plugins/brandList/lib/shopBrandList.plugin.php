<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 05.03.2016
 * Time: 21:35
 */

class shopBrandListPlugin extends shopPlugin{
    protected static $selfInfo = [
        'id' => 'brandList',
        'app_id' => 'shop'
    ];

    /**
     * Возвращает html-код категорий
     * @param int $categoryId
     * @param string $selectedBrand
     * @return mixed|string
     */
    public static function getBrands(int $categoryId = null, string $selectedBrand = null): string {
        $settings = (new self(static::$selfInfo))->getSettings();
        wa()->getResponse()->addJs('plugins/'.static::$selfInfo['id'].'/js/main.js', static::$selfInfo['app_id']);
        if(!$settings['active']){
            return '';
        }
        $featureModel = new shopFeatureModel();
        $innerFilter = '';
        if($categoryId !== null){
            $innerFilter .= ' AND p.category_id = '.$featureModel->escape($categoryId);
        }
        $brands = $featureModel->query('
            SELECT fv.value name, fv.id, COUNT(*) count
            FROM '.$featureModel->getTableName().' f
            INNER JOIN '.(new shopFeatureValuesVarcharModel())->getTableName().' fv ON f.id = fv.feature_id
            INNER JOIN '.(new shopProductFeaturesModel())->getTableName().' pf ON pf.feature_value_id = fv.id AND f.id = pf.feature_id
            INNER JOIN '.(new shopProductModel())->getTableName().' p ON p.id = pf.product_id
            WHERE pf.sku_id IS NULL'.$innerFilter.' AND f.code = \'brand\'
            GROUP BY 1');
        $view = wa()->getView();
        $view->assign('selectedBrand', $selectedBrand);
        $view->assign('brands', $brands);
        $view->assign('selfInfo', static::$selfInfo);
        return $view->fetch(static::getPluginTemplatePath());
    }
}