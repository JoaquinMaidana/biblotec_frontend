<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class LibroController extends Controller
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
            ->setUrl('http://localhost:3000/libros')
            ->send();

        if ($response->isOk) {
            
            // Decodificar el contenido JSON en un array asociativo 
            $data = json_decode($response->getContent(), true);
            $libros_array = array();
            $string = json_encode($data);
           // var_dump($string);
            
            foreach ($data as $libro) {
                // Agregar cada libro al arreglo de libros
                array_push($libros_array, $libro);
            }
            
           
              
              // Imprimir el string JSON
              
            

        }
        return $this->render('index',[
            'librosJson' => $string,
            'libros_Array' => $libros_array
        ]);
    }

    public function actionCreate()
    {
        //primero  consulto si la peticion vino por post
        if ($this->request->post()) {
            $this->save();
        }
        return $this->render('crearLibro');
    }

    public function actionUpdate($idlibros)
    {
        $libro = $this->findLibro($idlibros);

        if ($this->request->post()) {
            $this->save('PUT');
        }

        return $this->render('modificarLibro', [
            'libro' => $libro,
        ]);
    }

    public function actionDelete($idlibros)
    {
        $libro = $this->findLibro($idlibros);
        $this->delete($libro['id']);
        return $this->redirect(['index']);
       
    }


    public function actionView($idlibros)
    {
        $idlibros = intval($idlibros);
        $libro = $this->findLibro($idlibros);
        return $this->render('detalleLibro', [
            'libro' => $libro
        ]);
    }

    protected function findLibro($idlibros)
    {
      
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://localhost:3000/libros/' . $idlibros)
            ->send();
            
        if ($response->isOk) {
            $libro = json_decode($response->getContent(), true);
            return $libro;
        } else {
            return $libro="";
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
    $url = 'http://localhost:3000/libros';
    $client = new Client();

    if ($httpMethod === 'PUT') {
        $url .= '/' . Yii::$app->request->post('id');
        $response = $client->createRequest()
            ->setMethod('PUT')
            ->setUrl($url)
            ->addHeaders(['content-type' => 'application/json'])
            ->setContent(Json::encode([
                "id" =>Yii::$app->request->post('id'),
                "lib_isbn"=>Yii::$app->request->post('lib_idbn'),
                "lib_titulo"=>Yii::$app->request->post('lib_titulo'),
                "lib_descripcion"=>Yii::$app->request->post('lib_descripcion'),
                "lib_imagen" =>Yii::$app->request->post('lib_imagen'),
                "lib_categoria"=>Yii::$app->request->post('lib_categoria'),
                "lib_sub_categoria"=>Yii::$app->request->post('lib_sub_categoria'),
                "lib_url"=>Yii::$app->request->post('lib_url'),
                "lib_stock"=>Yii::$app->request->post('lib_stock'),
                "lib_autores"=>Yii::$app->request->post('lib_autores'),
                "lib_edicion"=>Yii::$app->request->post('lib_edicion'),
                "lib_fecha_lanzamiento"=>Yii::$app->request->post('lib_fecha_lanzamiento'),
                "lib_novedades"=>Yii::$app->request->post('lib_novedades'),
                "lib_idioma" =>Yii::$app->request->post('lib_idioma'),
                "lib_disponible"=>Yii::$app->request->post('lib_disponible'),
                "lib_vigente"=>Yii::$app->request->post('lib_vigente'),
                "lib_puntuacion"=>Yii::$app->request->post('lib_puntuacion'),
            ]))
            ->send();
    } else {
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl($url)
            ->addHeaders(['content-type' => 'application/json'])
            ->setContent(Json::encode([
                "id" =>Yii::$app->request->post('id'),
                "lib_isbn"=>Yii::$app->request->post('lib_idbn'),
                "lib_titulo"=>Yii::$app->request->post('lib_titulo'),
                "lib_descripcion"=>Yii::$app->request->post('lib_descripcion'),
                "lib_imagen" =>Yii::$app->request->post('lib_imagen'),
                "lib_categoria"=>Yii::$app->request->post('lib_categoria'),
                "lib_sub_categoria"=>Yii::$app->request->post('lib_sub_categoria'),
                "lib_url"=>Yii::$app->request->post('lib_url'),
                "lib_stock"=>Yii::$app->request->post('lib_stock'),
                "lib_autores"=>Yii::$app->request->post('lib_autores'),
                "lib_edicion"=>Yii::$app->request->post('lib_edicion'),
                "lib_fecha_lanzamiento"=>Yii::$app->request->post('lib_fecha_lanzamiento'),
                "lib_novedades"=>Yii::$app->request->post('lib_novedades'),
                "lib_idioma" =>Yii::$app->request->post('lib_idioma'),
                "lib_disponible"=>Yii::$app->request->post('lib_disponible'),
                "lib_vigente"=>Yii::$app->request->post('lib_vigente'),
                "lib_puntuacion"=>Yii::$app->request->post('lib_puntuacion'),
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
