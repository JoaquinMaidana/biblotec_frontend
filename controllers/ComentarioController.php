<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class ComentarioController extends Controller
{
    private $idLibro;
    public function actionIndex()
    {
        //$idLibro = $_POST['idLibro'];
        //$tituloLibro = $_POST['tituloLibro'];
        $idLibro = 9;
        $this->idLibro =9;
        $tituloLibro = "Ejemplo";
        $comentarios = json_decode($this->obtenerComentariosPadres($idLibro));
        $comentarios = $this->obtenerComentariosLibro($comentarios);

        return $this->render('index', [
            'comentarios' => $comentarios,
            'tituloLibro' => $tituloLibro,
            'idLibro' => $idLibro
        ]);
      
    }

    public function actionGetComentarios($idLibro){
        $this->idLibro =$idLibro;
         $tituloLibro = "Ejemplo";
        $comentarios = json_decode($this->obtenerComentariosPadres($idLibro));
        $comentarios = $this->obtenerComentariosLibro($comentarios);

        return $comentarios;

    }

    public function actionCreate()
    {
        $idLibro = $_POST['idLibro'];
        $isbn = $_POST['isbn'];
      
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

        if ($this->request->post()) {
            $this->save();
        }

        // $idUsuario = $_POST['idUsuario']; //No estoy seguro de como se consigue todavia
        //Llamada a la API para crear
        return $this->redirect(['libro/view', "id2" => $isbn]);
    }

    public function actionUpdate()
    {
        $id = $_POST['id'];
        $isbn = $_POST['isbn'];
       
        $comentario = $_POST['comentario'];
        if ($this->request->post()) {
            $this->save('PUT');
        }
        //Llamada a la API para actualizar
        return $this->redirect(['libro/view', "id2" => $isbn]);
    }

    public function actionDelete()
    {
        $isbn = $_POST['isbn'];
        $id = $_POST['id'];
        $tituloLibro = $_POST['tituloLibro'];

        //Llamada a la API para desactivar
        return $this->redirect(['libro/view', "id2" => $isbn]);
    }

    public function obtenerComentariosPadres($idLibro)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
        //    ->setUrl('http://152.70.212.112:3000/comentarios?comt_vigente=S&comet_padre_id=0&comet_lib_id=' . $idLibro)
             ->setUrl('http://152.70.212.112/comentarios/vigentes')
             ->addHeaders(['content-type' => 'application/json'])
            ->setContent(Json::encode([
                "lib_id" =>$this->idLibro,
            ]))
            ->send();

            $cometarios = json_decode($response->getContent(), true);

            // Filtrar los comentarios que tienen comet_padre_id igual a null
            $comentariosFiltrados = array_filter($cometarios, function ($comentario) {
                return $comentario['comet_padre_id'] === null;
            });
            $comentariosFiltradosJson = json_encode($comentariosFiltrados);
        return $comentariosFiltradosJson;
    }

    public function obtenerComentariosHijos($idComentario)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
        //    ->setUrl('http://152.70.212.112:3000/comentarios?comt_vigente=S&comet_padre_id=' . $idComentario)
            ->setUrl('http://152.70.212.112/comentarios/vigentes')
            ->addHeaders(['content-type' => 'application/json'])
            ->setContent(Json::encode([
                "lib_id" =>$this->idLibro,
                "comet_id" => $idComentario,
            ]))
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
            $index['usu_nombre'] = $comentarioPadre->usu_nombre;
            $index['usu_documento'] = $comentarioPadre->usu_documento;

            $comentariosHijos = json_decode($this->obtenerComentariosHijos($comentarioPadre->comet_id));
            $index['comentariosHijos'] = $this->obtenerComentariosLibro($comentariosHijos);

            array_push($comentarios, $index);
        }
        return $comentarios;
    }

        protected function save($httpMethod='post')
    {
        $url = 'http://152.70.212.112/comentarios';
        $client = new Client();
        $token = Yii::$app->request->post('token');
        $currentDateTime = (new \DateTime())->format('Y-m-d H:i:s');
        $referenciaid = Yii::$app->request->post('comentarioReferencia');
            $padreid = Yii::$app->request->post('comentarioPadre');
          
            if (Yii::$app->session->isActive) {      
                 $token = Yii::$app->session->get('usu_token'); 
                $usu_id =  Yii::$app->session->get('usu_id');         
            }    
            


        if ($httpMethod === 'PUT') {
            $url .= '/update?id=' . Yii::$app->request->post('id');
            if(isset($referenciaid)&& $referenciaid != '' && isset($padreid)&& $padreid != ''){
                $response = $client->createRequest()

                ->setMethod('put')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                ])
                ->setContent(Json::encode([
                    "comet_fecha_hora" => $currentDateTime,
                    "comet_usu_id" => $usu_id,
                    "comet_lib_id" => Yii::$app->request->post('idLibro'),
                    "comet_comentario" => Yii::$app->request->post('comentario'),
                    "comet_referencia_id" => $referenciaid,
                    "comet_padre_id" => $padreid,
                    
                ]))
                ->send();
            }else{
                
                $response = $client->createRequest()
                
                ->setMethod('put')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                
                
                ])
                
                ->setContent(Json::encode([
                    "comet_fecha_hora" => $currentDateTime,
                    "comet_usu_id" => $usu_id,
                    "comet_lib_id" => Yii::$app->request->post('idLibro'),
                    "comet_comentario" => Yii::$app->request->post('comentario'),
                    
                    
                ]))
                ->send();

            }
            
        } else {
            
            if(isset($referenciaid)&& $referenciaid != '' && isset($padreid)&& $padreid != ''){
                $response = $client->createRequest()

                ->setMethod('post')
                ->setUrl($url.'/create')
                ->addHeaders(['content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
        
                 ])
                ->setContent(Json::encode([
                    "comet_fecha_hora" => $currentDateTime,
                    "comet_usu_id" => $usu_id,
                    "comet_lib_id" => Yii::$app->request->post('idLibro'),
                    "comet_comentario" => Yii::$app->request->post('comentario'),
                    "comet_referencia_id" => $referenciaid,
                    "comet_padre_id" => $padreid,
                    
                ]))
                ->send();
            }else{
                
                $response = $client->createRequest()
                
                ->setMethod('post')
                ->setUrl($url.'/create')
                ->addHeaders(['content-type' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                
                
                ])
                
                ->setContent(Json::encode([
                    "comet_fecha_hora" => $currentDateTime,
                    "comet_usu_id" => $usu_id,
                    "comet_lib_id" => Yii::$app->request->post('idLibro'),
                    "comet_comentario" => Yii::$app->request->post('comentario'),
                    
                    
                ]))
                ->send();

            }
            
        }

        return $response->isOk ? true : false;
    }
}
