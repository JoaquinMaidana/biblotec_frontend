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
        $idLibro = 2;
        $this->idLibro =2;
        $tituloLibro = "Ejemplo";
        $comentarios = json_decode($this->obtenerComentariosPadres($idLibro));
        $comentarios = $this->obtenerComentariosLibro($comentarios);

        return $this->render('index', [
            'comentarios' => $comentarios,
            'tituloLibro' => $tituloLibro
        ]);
    }

    public function actionCreate()
    {
        $idLibro = $_POST['idLibro'];
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

        protected function save($httpMethod='post')
    {
        $url = 'http://localhost/proyectos%20php/bibliotec_backend/web/comentarios';
        $client = new Client();
        $token = Yii::$app->request->post('token');
        
        $referenciaid = Yii::$app->request->post('comet_referencia_id');
            $padreid = Yii::$app->request->post('comet_padre_id');
            $fecha_hora = Yii::$app->request->post('comet_fecha_hora');
            
            if(isset($fecha_hora)){
                $fecha_convertida = date("Y-m-d", strtotime($fecha_hora));
                // Obtener la hora actual
                $hora_actual = date("H:i:s");

                // Combinar la fecha y la hora
                $fecha_hora_actual = $fecha_convertida . " " . $hora_actual;
            }


        if ($httpMethod === 'PUT') {
            $url .= '/update?id=' . Yii::$app->request->post('id');
            if(isset($referenciaid)&& $referenciaid != '' && isset($padreid)&& $padreid != ''){
                $response = $client->createRequest()

                ->setMethod('put')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json'])
                ->setContent(Json::encode([
                    "comet_fecha_hora" => $fecha_hora_actual,
                    "comet_usu_id" => Yii::$app->request->post('comet_usu_id'),
                    "comet_lib_id" => Yii::$app->request->post('comet_lib_id'),
                    "comet_comentario" => Yii::$app->request->post('comet_comentario'),
                    "comet_referencia_id" => $referenciaid,
                    "comet_padre_id" => $padreid,
                    
                ]))
                ->send();
            }else{
                
                $response = $client->createRequest()
                
                ->setMethod('put')
                ->setUrl($url.'/create')
                ->addHeaders(['content-type' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                
                
                ])
                
                ->setContent(Json::encode([
                    "comet_fecha_hora" => $fecha_hora_actual,
                    "comet_usu_id" => Yii::$app->request->post('comet_usu_id'),
                    "comet_lib_id" => Yii::$app->request->post('comet_lib_id'),
                    "comet_comentario" => Yii::$app->request->post('comet_comentario'),
                    
                    
                ]))
                ->send();

            }
            
        } else {
            
            if(isset($referenciaid)&& $referenciaid != '' && isset($padreid)&& $padreid != ''){
                $response = $client->createRequest()

                ->setMethod('post')
                ->setUrl($url.'/create')
                ->addHeaders(['content-type' => 'application/json'])
                ->setContent(Json::encode([
                    "comet_fecha_hora" => $fecha_hora_actual,
                    "comet_usu_id" => Yii::$app->request->post('comet_usu_id'),
                    "comet_lib_id" => Yii::$app->request->post('comet_lib_id'),
                    "comet_comentario" => Yii::$app->request->post('comet_comentario'),
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
                    "comet_fecha_hora" => $fecha_hora_actual,
                    "comet_usu_id" => Yii::$app->request->post('comet_usu_id'),
                    "comet_lib_id" => Yii::$app->request->post('comet_lib_id'),
                    "comet_comentario" => Yii::$app->request->post('comet_comentario'),
                    
                    
                ]))
                ->send();

            }
            
        }

        return $response->isOk ? true : false;
    }
}
