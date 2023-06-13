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
        //->headers->set('Content-Type', 'application/json')
        ->setUrl('http://152.70.212.112/favoritos/obtener-favoritos?token=64879b980eea2')
        ->send();
       

        if ( $response2->isOk) {
            
            // Decodificar el contenido JSON en un array asociativo
           // var_dump(json_decode($response2->getContent(), true));
            $data =  json_decode($response2->getContent(), true);
           // var_dump($fav);exit;
            $fav2 =$data['data'];
          

           // $stringfav= json_encode($fav);
        
              
              // Imprimir el string JSON

        }else {var_dump("No fue ok");exit;}

        return $this->render('index',[
            'favoritos' => $fav2
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
      
        if ($this->request->post()) {
            //var_dump("del if",$fav);exit;
           // var_dump($this->request->post());exit;
            $this->deleteFav('PUT');
        }

        return $this->actionIndex();
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


    protected function updateFav($httpMethod='')
    {   //var_dump("favoritos controller delete fav",$_POST["idlibro"],$_POST["idusu"],$_POST["idfav"],$_POST["estado"]);exit;
        $url = 'http://152.70.212.112/favoritos';
        $client = new Client();
    
        if ($httpMethod === 'post') {
            $url .= '/delete?id=' . $_POST["id"];
            
           
          //var_dump($favorito['fav_usu_id']);exit;
            $response = $client->createRequest()
                ->setMethod('DELETE')
                ->setUrl($url)
                ->addHeaders(['content-type' => 'application/json'])
                
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