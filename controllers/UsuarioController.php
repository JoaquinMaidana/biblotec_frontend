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
        if (Yii::$app->session->isActive) {      
            $token = Yii::$app->session->get('usu_token');    
                
        }
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/usuarios/listado')
            ->addHeaders(['Authorization' => 'Bearer ' . $token])
            ->send();

            $usuarios = json_decode($response->getContent(), true);
            $usuarios_json = json_encode($usuarios['data']);

        return $this->render('index', [
            'usuarios' => $usuarios_json
        ]);
    }

    public function actionCreate()
    {
        //en desuso
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

        if ($this->request->post() && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['telefono'])) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $correo = $_POST['correo'];
            $telefono = $_POST['telefono'];
            $documento = $_POST['documento'];
            $habilitado = $_POST['habilitado'];
            $tipo = $_POST['tipo'];

            if (Yii::$app->session->isActive) {      
                $token = Yii::$app->session->get('usu_token');    
                    
            }
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('put')
                ->setUrl('http://152.70.212.112/usuarios/update')
                ->addHeaders(['content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
                ])
                ->setContent(Json::encode([
                    "id" => $id,
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "correo" => $correo,
                    "telefono" => $telefono,
                    "documento" => $documento,
                    "habilitado" => $habilitado,
                    "tipo" => $tipo
                    
                  
                ]))
                ->send();

               

            //Llamada a la API para actualizar
            return $this->redirect(['index']);
        } else {

            $usuario = $this->findUsuario($id);

            return json_encode($usuario);
        }
    }

    public function actionDelete()
    {
        $id = $_POST['id'];
        $motivo = $_POST['motivo'];
        if (Yii::$app->session->isActive) {      
            $token = Yii::$app->session->get('usu_token');
                 
        }
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('put')
            ->addHeaders(['content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            ])
            ->setUrl('http://152.70.212.112/usuarios/delete')
            ->setContent(Json::encode([

                "id" =>$id,
                "motivo" => $motivo,
              
            ]))
            ->send();

        return $this->redirect(['index']);
       
    }

    public function actionActivate()
    {
        $id = $_POST['id'];
        $motivo = $_POST['motivo'];
        if (Yii::$app->session->isActive) {      
            $token = Yii::$app->session->get('usu_token');
                 
        }
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('put')
            ->addHeaders(['content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
            ])
            ->setUrl('http://152.70.212.112/usuarios/activar?id='.$id)
            
            ->send();

        return $this->redirect(['index']);
       
    }

    public function findUsuario($usu_id)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/usuarios/find?doc=' . $usu_id)
            ->send();

        if ($response->isOk) {
            $data = json_decode($response->getContent(), true);
            $user = $data['data'];
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
