<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;

class ReporteController extends Controller
{

     /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->session->isActive && Yii::$app->session->get('usu_tipo_usuario') && Yii::$app->session->get('usu_tipo_usuario')=='Administrador') {      
            $token = Yii::$app->session->get('usu_token');    
                
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl('http://152.70.212.112/reportes/obtener-listado-reportes?token='.$token)
                ->send();

                $usuarios = json_decode($response->getContent(), true);
                $reportes = $usuarios['datos']['reportes'];
                $reportes_json = json_encode($reportes);
                return $this->render('index', [
                    'reportes_json' => $reportes_json
                ]);
        }
   
      
    }

    public function actionCreate(){
        $token = Yii::$app->session->get('usu_token');    
                
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl('http://152.70.212.112/reportes/ejecutar-reporte')
            ->addHeaders(['content-type' => 'application/x-www-form-urlencoded','Authorization' => 'Bearer ' . $token])
            ->setContent(http_build_query([
                "reporte" => Yii::$app->request->post('idReporte'),
                "datos" => Yii::$app->request->post('datos'),
                
            ]))
            ->send();

            

        $this->redirect('index');


    }

    

}