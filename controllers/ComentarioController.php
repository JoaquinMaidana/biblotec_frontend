<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class UsuarioController extends Controller
{
    public function actionIndex()
    {
        $idLibro = $_POST['idLibro'];
        $tituloLibro = $_POST['tituloLibro'];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost:3000/comentarios?comt_vigente=S&?comet_lib_id=' . $idLibro)
            ->send();

        return $this->render('index', [
            'comentarios' => $response->getContent(),
            'tituloLibro' => $tituloLibro
        ]);
    }

    public function actionCreate()
    {
        $idLibro = $_POST['idLibro'];
        $comentario = $_POST['comentario'];
        $comentarioPadre = $_POST['comentarioPadre']; //Puede llegar nulo si es un nuevo comentario y no una respuesta
        $comentarioReferencia = $_POST['comentarioReferencia']; //Puede llegar nulo si es un nuevo comentario y no una respuesta
        // $idUsuario = $_POST['idUsuario']; //No estoy seguro de como se consigue todavia
        //Llamada a la API para crear
        return $this->redirect(['index']);
    }

    public function actionUpdate()
    {
        $id = $_POST['id'];
        $comentario = $_POST['comentario'];

        //Llamada a la API para actualizar
        return $this->redirect(['index']);
    }

    public function actionDelete()
    {
        $id = $_POST['id'];

        //Llamada a la API para desactivar
        return $this->redirect(['index']);
    }
}
