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
            ->setUrl('http://152.70.212.112/categorias/listado')
            ->addHeaders(['Authorization' => 'Bearer ' . 'user'])
            ->send();

        $data = json_decode($response->getContent(), true);
        $categorias= $data['data'];
        $categorias_json = json_encode($categorias);
        return $this->render('index', [
            'categorias' => $categorias_json,
        ]);
    }

    public function actionGetCategorias(){
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/categorias/listado')
            ->send();

        $data = json_decode($response->getContent(), true);
        $categoria = $data['data'];
        
        return $categoria;
    }

    public function actionGetCategorias2(){
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/categorias/listado')
            ->addHeaders(['Authorization' => 'Bearer ' . 'user'])
            ->send();

        $data = json_decode($response->getContent(), true);
        $categorias= $data['data'];
        $categorias_json = json_encode($categorias);

        return $categorias_json;

    }

    public function actionCreate()
    {
        if ($this->request->post()) {
            $nombre = $_POST["nombre"];
            $this->save();
        }
        

        return $this->redirect(['index']);
    }

    public function actionUpdate()
    {
       
       
        if ($this->request->post()) {
            $nombre = $_POST["nombre"];
            $id = $_POST["id"];
            $this->save('PUT');
        }
        return $this->redirect(['index']);
    }

    public function actionDelete()
    {
        if ($this->request->post()) {
            $id = $_POST["id"];
            $client = new Client();
            $response = $client->createRequest()
            ->setMethod('put')
            ->setUrl('http://localhost/proyectos%20php/bibliotec_backend/web/categorias/delete?id='.$id)
            ->addHeaders(['content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . 'user',
            ])->send();
        }
        return $this->redirect(['index']);
    }


    protected function save($httpMethod='post')
    {
        $url = 'http://localhost/proyectos%20php/bibliotec_backend/web/categorias';
        $client = new Client();

        if ($httpMethod === 'PUT') {
            $url .= '/update';
            $response = $client->createRequest()
            ->setMethod('put')
            ->setUrl($url)
            ->addHeaders(['content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . 'user',
            
            
            ])
            ->setContent(Json::encode([   
                "nombre" => Yii::$app->request->post('nombre'),
                "id" => Yii::$app->request->post('id'),      
            ]))
            ->send();
        } else {
            $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl($url.'/create')
            ->addHeaders(['content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . 'user',
            
            
            ])
            ->setContent(Json::encode([   
                "nombre" => Yii::$app->request->post('nombre'),
                "vigente" => 'S',      
            ]))
            ->send();
        }

        if ($response->isOk) {
            
            return true;
        } else {
            return false;
        }
    }
}
