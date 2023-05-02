<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class SubcategoriaController extends Controller
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
            ->setUrl('http://localhost:3000/sub_categorias')
            ->send();

        $response2 = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost:3000/categorias')
            ->send();

        return $this->render('index', [
            'sub_categorias' => $response->getContent(),
            'categorias' => json_decode($response2->getContent())
        ]);
    }

    public function actionCreate()
    {
        $nombre = $_POST["nombre"];
        $categoria = $_POST["categoria"];
    }

    public function actionUpdate()
    {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $categoria = $_POST["categoria"];
    }

    public function actionDelete()
    {
        $id = $_POST["id"];
    }
}
