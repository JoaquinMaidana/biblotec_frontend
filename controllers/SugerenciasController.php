<?php 
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class SugerenciasController extends Controller{
    
    public function actionIndex()
    { 
      if(isset($_POST['action']) ){
        $action = $_POST['action'];
        if ($action == 'remove')
        {
             $id= $_POST['id'][0];

             //Remove code

                  echo '{}';
        }
        elseif ($action == 'edit')
        {
           $id= $_POST['id'];
           $data = $_POST['data'];

           return $this->render('update',[
            'idsugerencias' => $id,
        ]);

        }
      } 

       
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/sugerencias/listado')
            ->send();

        if ($response->isOk) {
            
            // Decodificar el contenido JSON en un array asociativo 
            $data = json_decode($response->getContent(), true);
            $sugerencias_array = array();
            $string = json_encode($data);
          //  var_dump($string);exit;
            
            foreach ($data as $sugerencia) {
                // Agregar cada libro al arreglo de libros
                array_push($sugerencias_array, $sugerencia);
            }
              
              // Imprimir el string JSON

        }else {var_dump("No fue ok");exit;}

        return $this->render('index',[
            'sugerenciasJson' => $string,
            'sugerencias_Array' => $sugerencias_array
        ]);
    }

    public function actionCreate()
    {
        //primero  consulto si la peticion vino por post
        if ($this->request->post()) {
            $sug_sugerencia = $_POST['sugerencia'];
          //  var_dump(Yii::$app->request->post('sug_sugerencia'), "yii POST", $sug_sugerencia, "Post");exit;
            
        }
        
        return $this->render('crearSugerencia');
    }


    public function actionCreatee(){
        $url = 'http://152.70.212.112/sugerencias';
        $client = new Client();
        //var_dump($httpMethod='post');exit;
        if (Yii::$app->session->isActive) {      
            $token = Yii::$app->session->get('usu_token');      
            $usu_id =  Yii::$app->session->get('usu_id');    
        }

        $response = $client->createRequest()
        ->setMethod('post')
        ->setUrl($url)
        ->addHeaders(['content-type' => 'application/json',
        'Authorization' => 'Bearer ' . $token])
        ->setContent(Json::encode([
            "sug_sugerencia"=>Yii::$app->request->post('sugerencia'),
            "sug_usu_id" => $usu_id,
            "sug_nombre_libro" => "-"
          
        ])) 
        ->send();

        $this->redirect('view');


    }

    public function actionNew()
    {
        if (count($_POST) != 0 )
            {
                if ($this->request->post()) {
                    //var_dump( $_POST["sug_sugerencia"], Yii::$app->user->identity->id,);exit;
                    $this->saveSug();
                }
            }
        return $this->render('crearSugerencia');
    }

    public function actionView()
    {

        if (Yii::$app->session->isActive) {
           
            $usu_id =  Yii::$app->session->get('usu_id');
        }
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/sugerencias/obtener-de-usuario?id='.$usu_id)
            ->send();

        if ($response->isOk) {
            
            // Decodificar el contenido JSON en un array asociativo 
            $data = json_decode($response->getContent(), true);
            
            $sugerencias =$data['sugerencias'];
            

        } 

        

        return $this->render('misSugerencias', [
            'sugerencias' => json_encode($sugerencias),
        ]);
    }


    public function actionUpdate()
    {
        

        if ($this->request->post()) {
          
            $this->saveSug('PUT');
           
        }                           

        return $this->actionIndex();
    }
   

    protected function findSugerencia($idsugerencia)
    {
      
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/sugerencias/' . $idsugerencia)
            ->send();
            
        if ($response->isOk) {
            $sugerencia = json_decode($response->getContent(), true);
            return $sugerencia;
        } else {
            return $sugerencia="";
        }


    }

    protected function findSugerencias()
    {
      
       
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/sugerencias')
            ->send();

        if ($response->isOk) {
            
            // Decodificar el contenido JSON en un array asociativo 
            $data = json_decode($response->getContent(), true);
            
            $sugerencias =$data;
            

        } else {
            return $sugerencia="";
        }

        return $sugerencias; 


    }

    protected function saveSug($httpMethod='post')
    {
        $url = 'http://152.70.212.112/sugerencias';
        $client = new Client();
        //var_dump($httpMethod='post');exit;
        if (Yii::$app->session->isActive) {      
            $token = Yii::$app->session->get('usu_token');          
        }
        if ($httpMethod === 'PUT') {
            //var_dump(Yii::$app->request->post('nuevoEstado'),"get",Yii::$app->request->get('sugerencia')['id'] );exit;
            $url .= '/modificar-estado' ;
            $newEstado = Yii::$app->request->post('nuevo_e');
            
            //var_dump($url, $newEstado); exit;
            $response = $client->createRequest()
                ->setMethod('put')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $token])
                ->setContent(Json::encode([
                    "sug_id" => Yii::$app->request->post('id'),
                    
                    "sug_vigente"=>$newEstado,
                  
                ])) 
                ->send();
        } else {
            $response = $client->createRequest()
                ->setMethod('post')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $token])
                ->setContent(Json::encode([
                    
                    "sug_sugerencia"=>Yii::$app->request->post('sug_sugerencia'),
                    "sug_nombre_libro"=>Yii::$app->request->post('libro_sug'),
                    "sug_usu_id"=>Yii::$app->request->post('sug_idusu'),
                    
                ]))
                ->send();
        }
    
        if ($response->isOk) {
            
            return true;
        } else {
            return false;
        }
    }

    protected function deleteSug($httpMethod='post'){
         $url = 'http://152.70.212.112:3000/sugerencias';
        $client = new Client();
        //var_dump($httpMethod='post');exit;
    
        if ($httpMethod === 'PUT') {
            //var_dump(Yii::$app->request->post('nuevoEstado'),"get",Yii::$app->request->get('sugerencia')['id'] );exit;
            $url .= '/' . Yii::$app->request->get('sugerencia')['id'];
            $newEstado = Yii::$app->request->post('nuevoEstado');
            //var_dump($url, $newEstado); exit;
            $response = $client->createRequest()
                ->setMethod('PUT')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json'])
                ->setContent(Json::encode([
                    "id" =>Yii::$app->request->get('sugerencia')['id'],
                    "sug_sugerencia"=>Yii::$app->request->get('sugerencia')['sug_sugerencia'],
                    "sug_vigente"=>$newEstado,
                    "sug_idusu"=>Yii::$app->request->get('sugerencia')['sug_idusu'],
                    "sug_fecha" =>Yii::$app->request->get('sugerencia')['sug_fecha'],
                ])) 
                ->send();
        } else {
            $response = $client->createRequest()
                ->setMethod('post')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json'])
                ->setContent(Json::encode([
                    "id" =>"",
                    "sug_sugerencia"=>Yii::$app->request->post('sug_sugerencia'),
                    "sug_vigente"=>"S",
                    "sug_idusu"=>Yii::$app->user->identity->id,
                    "sug_fecha" => date('Y-m-d')
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
