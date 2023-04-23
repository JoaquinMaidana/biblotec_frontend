<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\httpclient\Client;
use yii\helpers\Json;

class LibroController extends Controller
{
    

   
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost/xampp/php%20CRUDS/yii2/CRUD1/bibloteca/web/libroos')
            ->send();

        $libros = [];

        if ($response->isOk) {
            $libros=$response->data;
        }
        return $this->render('index',[
            'libros' => $libros
        ]);
    }

    
}
