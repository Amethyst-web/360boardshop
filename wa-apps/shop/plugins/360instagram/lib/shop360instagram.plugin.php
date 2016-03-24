<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 05.03.2016
 * Time: 21:35
 */

class shop360instagramPlugin extends shopPlugin{
//    private static $accessToken = '281600752.424a938.8597e6e921644237a28d27a76d549659';
    private static $accessToken = '1826680073.4b3fe8b.7607b9c4d68d4773a84d52b55d173e11';
    protected static $selfInfo = [
        'id' => '360instagram',
        'app_id' => 'shop'
    ];
    /**
     * Возвращает html-код с последними фото
     * @return mixed
     */
//    PHP7
//    public static function getLastPhotos(): string {
    public static function getLastPhotos() {
        $settings = (new self(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
        $ch = curl_init('https://api.instagram.com/v1/users/self/media/recent/?access_token='.static::$accessToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $recentPhotos = curl_exec($ch);
        curl_close($ch);
        $recentPhotos = json_decode($recentPhotos, true);
        $view = wa()->getView();
        $view->assign('recentPhotos', $recentPhotos['data']);
        return $view->fetch(static::getPluginTemplatePath());
    }
}