<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 05.03.2016
 * Time: 21:35
 */

class shop360breadcrumbsPlugin extends shopPlugin{
    protected static $selfInfo = [
        'id' => '360breadcrumbs',
        'app_id' => 'shop'
    ];

    /**
     * Возвращает html-код с последними фото
     * @param int $category_id - id категории
     * @param int $product_id - id товара
     * @return mixed|string
     */
    public static function getCrumbs(int $category_id = null, int $product_id = null): string {
        $settings = (new self(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
        $breadcrumbs = [];
        if($category_id !== null){
            $categoryModel = new shopCategoryModel();
            $category = $categoryModel->getById($category_id);
            $path = array_reverse($categoryModel->getPath($category['id']));
            foreach ($path as $row) {
                $breadcrumbs[] = array(
                    'url' => static::getStCategoryUrl($row),
                    'name' => $row['name']
                );
            }
            if ($product_id === null) {
                $breadcrumbs[] = [
                    'name' => $category['name']
                ];
            } else {
                $breadcrumbs[] = [
                    'url' => static::getStCategoryUrl($category),
                    'name' => $category['name']
                ];
                $productModel = new shopProductModel();
                $product = $productModel->getById($product_id);
                $breadcrumbs[] = [
                    'name' => $product['name']
                ];
            }
        }
        $view = wa()->getView();
        $view->assign('breadcrumbs', $breadcrumbs);
        return $view->fetch(static::getPluginTemplatePath());
    }

    public static function getStaticBreadcrumbs(array $breadcrumbs = []){
        $settings = (new self(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
        $view = wa()->getView();
        $view->assign('breadcrumbs', $breadcrumbs);
        return $view->fetch(static::getPluginTemplatePath());
    }
}