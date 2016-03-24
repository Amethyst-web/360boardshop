<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 08.03.2016
 * Time: 12:51
 */
class siteSubscribePluginFrontendSubscribeController extends waJsonController{
    public function execute(){
        if(!waRequest::isXMLHttpRequest() || waRequest::getMethod() !== 'post'){
            $this->response = [
                'result' => false,
                'message' => 'Method not allowed'
            ];
            return;
        }
        $params = waRequest::post();
        if(!isset($params['email'], $params['source'])){
            $this->response = [
                'result' => false,
                'message' => 'Not enough params'
            ];
            return;
        }
        $model = new subscriberModel();
        $sub = $model->getByField('email', $params['email']);
        if($sub !== null){
            $this->response = [
                'result' => false,
                'message' => 'You\'re already subscribe'
            ];
            return;
        }
        $restult = $model->insert([
            'email' => $params['email'],
            'gender' => $params['gender'],
            'source' => $params['source']
        ]);
        if($restult){
            $this->response = [
                'result' => true,
                'message' => 'You\'re successfully subscribe'
            ];
        } else {
            $this->response = [
                'result' => false,
                'message' => 'Error. Try again later'
            ];
        }
    }
}