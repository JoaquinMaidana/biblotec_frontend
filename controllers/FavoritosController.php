<?php 
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;
use yii\rest\IndexAction;

class FavoritosController extends Controller{
    
    public function actionIndex()
    { 
       
        $client = new Client();
        $response2=$client->createRequest()
        ->setMethod('get')
        ->setUrl('http://152.70.212.112:3000/favoritos')
        ->send();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/libros')
            ->send();

        if ($response->isOk && $response2->isOk) {
            
            // Decodificar el contenido JSON en un array asociativo
            $fav =  json_decode($response2->getContent(), true);
            $data = json_decode($response->getContent(), true);
           
            $string = json_encode($data);
            
            $stringfav= json_encode($fav);
        
              
              // Imprimir el string JSON

        }else {var_dump("No fue ok");exit;}

        return $this->render('index',[
            'libros' => $string,
            'favoritos' => $stringfav
        ]);
      
    }

/*    public function actionCreate()
    {
        //primero  consulto si la peticion vino por post
        if ($this->request->post()) {
            $this->saveSug();
        }
        return $this->render('crearSugerencia');
    }

   */ public function actionView()
    {   
        $idlibro = $_GET["idlibro"];
        $libro = $this->findLibro($idlibro);

        return $this->render('detallelibrofav', [
            'libro' => $libro,
        ]);
    }
    public function actionUpdate()
    {
        //idUsuario 0 $_POST['idUsuario'];
        $idLibro = $_POST['idLibro'];
        $fav = $_POST['fav']; //S/N

        //llamada a la API para actualizar
        return 0;
    }
    protected function findLibro($idlibro)
    {
      
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/libros/' . $idlibro)
            ->send();
            
        if ($response->isOk) {
            $libro = json_decode($response->getContent(), true);
            return $libro;
        } else {
            return $libro="";
        }
    }
    protected function findFavoritos($idusu)
    {
      
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/favoritos/' . $idusu)
            ->send();
            
        if ($response->isOk) {
            $favoritos = json_decode($response->getContent(), true);
            return $favoritos;
        } else {
            return $favoritos="";
        }
    }

    


    protected function deleteFav($httpMethod='post')
    {   //var_dump("favoritos controller delete fav",$_POST["idlibro"],$_POST["idusu"],$_POST["idfav"],$_POST["estado"]);exit;
        $url = 'http://152.70.212.112:3000/favoritos';
        $client = new Client();
    
        if ($httpMethod === 'PUT') {
            $url .= '/' . $_POST["idlibro"];
            if($_POST["estado"]==1){
                $new_estado = 1;
            }else{
                $new_estado = 0;
            }
           
          //var_dump($favorito['fav_usu_id']);exit;
            $response = $client->createRequest()
                ->setMethod('PUT')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['Authorization' => 'Bearer ' . 'user'])
                ->setContent(Json::encode([
                    "id" =>$_POST["idfav"],
                    "fav_usu_id"=>$_POST["idusu"],
                    "fav_lib_id"=>$_POST["idlibro"],
                    "fav_estado"=>$new_estado,
                    
                ])) 
                ->send();
        } else {
            $response = $client->createRequest()
                ->setMethod('post')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['Authorization' => 'Bearer ' . 'user'])
                ->setContent(Json::encode([
                    "id" =>Yii::$app->request->post('id'),
                    "sug_sugerencia"=>Yii::$app->request->post('sug_sugerencia'),
                    "sug_vigente"=>Yii::$app->request->post('sug_vigente'),
                    "sug_idusu"=>Yii::$app->request->post('sug_idusu'),
                    "sug_fecha" =>Yii::$app->request->post('sug_fecha'),
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

?>