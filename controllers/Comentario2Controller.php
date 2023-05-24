<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class Comentario2Controller extends Controller
{

     /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
    //    $client = new Client();
    //    $response = $client->createRequest()
    //        ->setMethod('get')
    //        ->setUrl('http://localhost:3000/libros')
    //        ->send();
    //    
    //    if ($response->isOk) {
    //        
    //        // Decodificar el contenido JSON en un array asociativo 
    //        $data = json_decode($response->getContent(), true);
    //        $libros_array = array();
    //        $string = json_encode($data);
    //       // var_dump($string);
     //       
     //       foreach ($data as $libro) {
    //            // Agregar cada libro al arreglo de libros
    //            array_push($libros_array, $libro);
    //        }
            
           
              
              // Imprimir el string JSON
              
            

    //    }
        return $this->render('index');
    }

    public function actionCreate()
    {
        //primero  consulto si la peticion vino por post
        if ($this->request->post()) {
            $this->save();
        }

        return $this->render('createComentario');
    }
    

    public function actionUpdate()
    {   
        $idcomentario = Yii::$app->request->post('id');
        $comentario = $this->findComentario($idcomentario);
        if ($this->request->post()) {
            $this->save('PUT');
        }

        
    }

    public function actionDelete($idlibros)
    {
        $libro = $this->findLibro($idlibros);
        $this->delete($libro['id']);
        return $this->redirect(['index']);
       
    }


    public function actionView()
    {
        $idcomentario = $_POST['idcomentario'];
        $comentario = $this->findLibro($idcomentario);
        return $this->render('detalleComentario', [
            'libro' => $comentario
        ]);
    }

    protected function findComentario($idcomentario)
    {
      
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost/proyectos%20php/bibliotec_backend/web/comentarios/view?id=' . $idcomentario)
            ->send();
            
        if ($response->isOk) {
            $comentario = json_decode($response->getContent(), true);
            return $comentario;
        } else {
            return $comentario="";
        }


    }


    protected function delete($idlibros=""){
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('delete')
            ->setUrl('http://localhost:3000/libros/' . $idlibros)
            ->send();
        return $response->isOk;

        
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