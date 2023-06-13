<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class ComentarioController extends Controller
{
    public function actionIndex($idLibro = null, $tituloLibro = null)
    {
        if ($idLibro == null) {
            $idLibro = $_POST['idLibro'];
            $tituloLibro = $_POST['tituloLibro'];
        }
        //$idLibro = 20;
        //$tituloLibro = "Ejemplo";
        $comentarios = json_decode(ComentarioController::obtenerComentariosPadres($idLibro));
        $comentarios = ComentarioController::obtenerComentariosLibro($comentarios);

        return $this->render('index', [
            'comentarios' => $comentarios,
            'tituloLibro' => $tituloLibro,
            'idLibro' => $idLibro
        ]);
    }

    public function actionCreate()
    {
        $idLibro = $_POST['idLibro'];
        $tituloLibro = $_POST['tituloLibro'];
        $comentario = $_POST['comentario'];

        if (isset($_POST['comentarioPadre'])) {
            $comentarioPadre = $_POST['comentarioPadre']; //Puede llegar nulo si es un nuevo comentario y no una respuesta
        } else {
            $comentarioPadre = 0;
        }
        if (isset($_POST['comentarioReferencia'])) {
            $comentarioReferencia = $_POST['comentarioReferencia']; //Puede llegar nulo si es un nuevo comentario y no una respuesta
        } else {
            $comentarioReferencia = 0;
        }

        // $idUsuario = $_POST['idUsuario']; //No estoy seguro de como se consigue todavia
        //Llamada a la API para crear
        return $this->redirect(['index', "idLibro" => $idLibro, "tituloLibro" => $tituloLibro]);
    }

    public function actionUpdate()
    {
        $id = $_POST['id'];
        $tituloLibro = $_POST['tituloLibro'];
        $comentario = $_POST['comentario'];

        //Llamada a la API para actualizar
        return $this->redirect(['index', "idLibro" => $id, "tituloLibro" => $tituloLibro]);
    }

    public function actionDelete()
    {
        $id = $_POST['id'];
        $tituloLibro = $_POST['tituloLibro'];

        //Llamada a la API para desactivar
        return $this->redirect(['index', "idLibro" => $id, "tituloLibro" => $tituloLibro]);
    }

    public function obtenerComentariosPadres($idLibro)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/comentarios?comt_vigente=S&comet_padre_id=0&comet_lib_id=' . $idLibro)
            ->send();

        return $response->getContent();
    }

    public function obtenerComentariosHijos($idComentario)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/comentarios?comt_vigente=S&comet_padre_id=' . $idComentario)
            ->send();

        return $response->getContent();
    }

    public function obtenerComentariosLibro($comentariosPadres)
    {

        $comentarios = array();
        foreach ($comentariosPadres as $comentarioPadre) {
            $index = array();
            $index['comet_id'] = $comentarioPadre->comet_id;
            $index['comet_fecha_hora'] = $comentarioPadre->comet_fecha_hora;
            $index['comet_usu'] = $comentarioPadre->comet_usu_id;
            $index['comet_lib_id'] = $comentarioPadre->comet_lib_id;
            $index['comet_comentario'] = $comentarioPadre->comet_comentario;
            $index['comet_referencia_id'] = $comentarioPadre->comet_referencia_id;
            $index['comet_padre_id'] = $comentarioPadre->comet_padre_id;

            $comentariosHijos = json_decode($this->obtenerComentariosHijos($comentarioPadre->comet_id));
            $index['comentariosHijos'] = $this->obtenerComentariosLibro($comentariosHijos);

            array_push($comentarios, $index);
        }
        return $comentarios;
    }
}
