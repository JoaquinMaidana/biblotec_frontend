<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class CategoriaController extends Controller
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
            ->setUrl('http://localhost:3000/categorias')
            ->send();

        return $this->render('index', [
            'categorias' => $response->getContent(),
        ]);
    }

    public function actionGetCategorias(){
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost:3000/categorias')
            ->send();

        $data = json_decode($response->getContent(), true);
        $categoria_array = array();
        
        return $categoria_array;
    }

    public function actionCreate()
    {
        $nombre = $_POST["nombre"];
    }

    public function actionUpdate()
    {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
    }

    public function actionDelete()
    {
        $id = $_POST["id"];
    }
}
