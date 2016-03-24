<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 05.03.2016
 * Time: 21:35
 */

class shopColorListPlugin extends shopPlugin{
    protected static $selfInfo = [
        'id' => 'colorList',
        'app_id' => 'shop'
    ];

    /**
     * Возвращает html-код цветов
     * @param int $categoryId
     * @param array $selectedColors
     * @return mixed|string
     */
//    PHP7
//    public static function getColors(int $categoryId = null, array $selectedColors = null): string {
    public static function getColors($categoryId = null, array $selectedColors = null){
        $settings = (new self(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
        $featureModel = new shopFeatureModel();
        $innerFilter = '';
        if($categoryId !== null){
            $innerFilter .= ' AND p.category_id = '.$featureModel->escape($categoryId);
        }
        $colors = $featureModel->query('
            SELECT fv.value name, fv.code, fv.id
            FROM '.$featureModel->getTableName().' f
            INNER JOIN '.(new shopFeatureValuesColorModel())->getTableName().' fv ON f.id = fv.feature_id
            INNER JOIN '.(new shopProductFeaturesModel())->getTableName().' pf ON pf.feature_value_id = fv.id AND f.id = pf.feature_id
            INNER JOIN '.(new shopProductModel())->getTableName().' p ON p.id = pf.product_id
            WHERE pf.sku_id IS NULL'.$innerFilter.' AND f.code = \'color\'')->fetchAll();
        $colorParser = new shopColorValue([]);
        foreach($colors as $key => $color){
            $colors[$key]['value'] = $colorParser->convert('hex', $color['code']);
        }
        $view = wa()->getView();
        $view->assign('selectedColors', $selectedColors);
        $view->assign('colors', $colors);
        $view->assign('selfInfo', static::$selfInfo);
        return $view->fetch(static::getPluginTemplatePath());
    }
}