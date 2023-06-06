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
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost/proyectos%20php/bibliotec_backend/web/usuarios/listado')
            ->addHeaders(['Authorization' => 'Bearer ' . 'user'])
            ->send();

            $usuarios = json_decode($response->getContent(), true);
            $usuarios_json = json_encode($usuarios['data']);

        return $this->render('index', [
            'usuarios' => $usuarios_json
        ]);
    }

    public function actionCreate()
    {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $documento = $_POST['documento'];
        $tipo = $_POST['tipo'];

        //Llamada a la API para crear
        return $this->redirect(['index']);
    }

    public function actionUpdate()
    {
        $id = $_POST['id'];

        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $documento = $_POST['documento'];
            $habilitado = $_POST['habilitado'];
            $tipo = $_POST['tipo'];

            //Llamada a la API para actualizar
            return $this->redirect(['index']);
        } else {

            $usuario = $this->findUsuario($id);

            return $usuario;
        }
    }

    public function actionDelete()
    {
        $id = $_POST['id'];

        //Llamada a la API para desactivar
        return $this->redirect(['index']);
    }

    public function findUsuario($usu_id)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost:3000/usuarios/' . $usu_id)
            ->send();

        if ($response->isOk) {
            $user = json_decode($response->getContent(), true);
            return $user;
        } else {
            return $user = "";
        }
    }

    public function findUser($usu_documento)
    {
      
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/users/' . $usu_documento)
            ->send();
            
        if ($response->isOk) {
            $user = json_decode($response->getContent(), true);
            return $user;
        } else {
            return $user="";
        }


    }
}
