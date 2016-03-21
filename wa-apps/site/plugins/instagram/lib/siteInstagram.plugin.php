<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 05.03.2016
 * Time: 21:35
 */

class siteInstagramPlugin extends waPlugin{
    private static $accessToken = '281600752.424a938.8597e6e921644237a28d27a76d549659';
    private static $selfInfo = [
        'id' => 'instagram',
        'app_id' => 'site'
    ];
    /**
     * Возвращает html-код с последними фото
     * @return mixed
     */
    public static function getLastPhotos(): string {
        $settings = (new siteInstagramPlugin(static::$selfInfo))->getSettings();
        if(!$settings['active']){
            return '';
        }
//        $ch = curl_init('https://api.instagram.com/v1/users/'.(new siteInstagramPlugin(static::$selfInfo))->getSettings('instagramId').'/media/recent/?access_token='.self::$accessToken);
        $ch = curl_init('https://api.instagram.com/v1/users/self/media/recent/?access_token='.self::$accessToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $recentPhotos = curl_exec($ch);
        curl_close($ch);
        $recentPhotos = json_decode($recentPhotos, true);
        $view = wa()->getView();
        $view->assign('recentPhotos', $recentPhotos['data']);
        $content = $view->fetch('plugins/'.self::$selfInfo['id'].'/templates/default.html');
        return $content;
    }
}