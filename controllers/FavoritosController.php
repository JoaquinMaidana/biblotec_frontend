<?php

namespace app\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;
use yii\rest\IndexAction;

class FavoritosController extends Controller
{

    public function actionIndex()
    {
        if (Yii::$app->session->isActive) {

            $token =  Yii::$app->session->get('usu_token');
        }
        $client = new Client();
        $response2 = $client->createRequest()
            ->setMethod('get')
            //->headers->set('Content-Type', 'application/json')
            ->setUrl('http://152.70.212.112/favoritos/obtener-favoritos?token=' . $token)
            ->send();


        if ($response2->isOk) {

            // Decodificar el contenido JSON en un array asociativo
            // var_dump(json_decode($response2->getContent(), true));
            $data =  json_decode($response2->getContent(), true);
            // var_dump($fav);exit;
            $fav2 = $data['data'];


            // $stringfav= json_encode($fav);


            // Imprimir el string JSON

        } else {
            var_dump("No fue ok");
            exit;
        }

        return $this->render('index', [
            'libros' => $fav2
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

   */
    public function actionView()
    {
        $idlibro = $_GET["idlibro"];
        $libro = $this->findLibro($idlibro);

        return $this->render('detallelibrofav', [
            'libro' => $libro,
        ]);
    }
    public function actionUpdate()
    {
        $idLibro = $_POST['idLibro'];
        $fav = $_POST['fav']; //S/N

        if (Yii::$app->session->isActive) {
            $token = Yii::$app->session->get('usu_token');
            $usu_id =  Yii::$app->session->get('usu_id');
        }

        if ($fav == 'S') {

            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('post')
                ->setUrl('http://152.70.212.112/favoritos/create')
                ->addHeaders([
                    'content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])->setContent(Json::encode([
                    "fav_lib_id" => $idLibro,
                    "fav_usu_id" => $usu_id,

                ]))
                ->send();
        } else {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('delete')
                ->setUrl('http://152.70.212.112/favoritos/delete?id=' . $idLibro)
                ->addHeaders([
                    'content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])
                ->send();
                var_dump($response->getContent());exit;
        }

        return $this->redirect(['get-favoritos']);
    }

    public function actionBaja()
    {
    }

    public function actionGetFavoritos()
    {
        $client = new Client();
        if (Yii::$app->session->isActive) {
            $token = Yii::$app->session->get('usu_token');
        }
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/favoritos/obtener-favoritos?token=' . $token)
            ->send();

        $data = json_decode($response->getContent(), true);
        $favoritos = $data['data'];

        return $favoritos;
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
            return $libro = "";
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
            return $favoritos = "";
        }
    }




    public function actionUpdatee()
    {   //var_dump("favoritos controller delete fav",$_POST["idlibro"],$_POST["idusu"],$_POST["idfav"],$_POST["estado"]);exit;
        $url = 'http://152.70.212.112/favoritos';
        $client = new Client();
        if (Yii::$app->session->isActive) {
            $token = Yii::$app->session->get('usu_token');
        }

        $url .= '/delete?id=' . Yii::$app->request->post('id_fav');


        //var_dump($favorito['fav_usu_id']);exit;
        $response = $client->createRequest()
            ->setMethod('DELETE')
            ->setUrl($url)
            ->addHeaders([
                'content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])

            ->send();

        return $this->redirect(['favoritos/index']);
    }
}
