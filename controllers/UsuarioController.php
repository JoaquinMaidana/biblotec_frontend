<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class UsuarioController extends Controller
{
    public function findUser($usu_documento)
    {
      
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost:3000/users/' . $usu_documento)
            ->send();
            
        if ($response->isOk) {
            $user = json_decode($response->getContent(), true);
            return $user;
        } else {
            return $user="";
        }


    }

}