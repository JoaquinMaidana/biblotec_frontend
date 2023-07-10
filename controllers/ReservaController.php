<?php

namespace app\controllers;

use DateInterval;
use DateTimeZone;
use Yii;
use Faker\Provider\DateTime;
use yii\helpers\Json;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\filters\AccessControl;
class ReservaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create'],
                'rules' => [
                //    [
                //        'actions' => ['index'],
                //        'allow' => true,
                //        //'roles' => ['@'],
                 //      'matchCallback' => function ($rule, $action) {
                //            if (!Yii::$app->session->get('usu_tipo_usuario') ) {
                //                return $this->redirect(['site/index']);
                 //           }
                 //           return true;
                 //       },
//
//
                 //   ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (!Yii::$app->session->get('usu_tipo_usuario') || Yii::$app->session->get('usu_tipo_usuario') != 'Administrador') {
                                return $this->redirect(['site/index']);
                            }
                            return true;
                        },


                    ],

                ],
            ],

        ];
    }


    public function actionIndex()
    {
        if (Yii::$app->session->isActive) {

            $usuario_id =  Yii::$app->session->get('usu_id');
        }


        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/reservas/obtener?id=' . $usuario_id)
            ->send();

        $reservaLibro = array();
        $data = json_decode($response->getContent());

        if ($data->error != true) {

            $reservas = $data->reserva;
            foreach ($reservas as $reserva) {
                $index = array();
                $index['reserva'] = $reserva;
                $index['libro'] = LibroController::findLibro($reserva->isbn_libro);
                array_push($reservaLibro, $index);
            }
        }
        return $this->render('index', [
            'reservasLibros' => $reservaLibro
        ]);
    }

    public function actionIndexAdmin()
    {
        if (Yii::$app->session->isActive) {
            $token = Yii::$app->session->get('usu_token');
        }
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->addHeaders(['Authorization' => 'Bearer ' . $token])
            ->setUrl('http://152.70.212.112/reservas/listado')
            ->send();

        $data = json_decode($response->getContent());
        $data2 = $data->data;
        $reservas = json_encode($data2);
        return $this->render('indexAdmin', [
            'reservas' => $reservas
        ]);
    }

    // se obtienen las fechas bloqueadas cuando hay mismo numero de reservas que el stock, y que el estado sea pend, levantado, y no devuelto
    public function actionFechasBloqueadas($id){
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112/reservas/obtener-de-libro?id='.$id)
            ->send();

        $data = json_decode($response->getContent());
        $stock = $data->lib_stock;
        $reservas = $data->reserva;

        $estadosFiltrados = ["P", "N", "L"]; 

        $reservasFiltradas = array_filter($reservas, function($reserva) use ($estadosFiltrados) {
            return in_array($reserva->resv_estado, $estadosFiltrados);
        });

        $cantidad_reserva = count($reservasFiltradas);

        if( $cantidad_reserva >= $stock){
            
            foreach ($reservasFiltradas as $reserva) {
                $fechaDesde = strtotime($reserva->resv_fecha_desde);
                $fechaHasta = strtotime($reserva->resv_fecha_hasta);
            
                // Agregar las fechas al array $blockedDates
                $fechaActual = $fechaDesde;
                while ($fechaActual <= $fechaHasta) {
                    $blockedDates[] = date('Y-m-d', $fechaActual);
                    $fechaActual = strtotime('+1 day', $fechaActual);
                }
            }

            $data2 = json_encode($blockedDates);
            return $data2;

        }
        else{
            
            
        //    $currentDate = date('Y-m-d'); // Obtener la fecha actual en formato 'YYYY-MM-DD'
            
            // Filtrar el array `blockedDates` a partir de la fecha actual
        //    $filteredDates = array_filter($blockedDates, function ($date) use ($currentDate) {
        //        return $date >= $currentDate;
        //    });
            $blockedDates = [];
            $data2 = json_encode($blockedDates);
            return $data2;
        }
        
       
        


    }

    public function actionCreate($isbn = "")
    {
        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        if ($this->request->post()) {
            $libro_id = $_POST['libro_id'];
            $fecha_desde = $_POST['fecha_desde'];
            $fecha_hasta = $_POST['fecha_hasta'];

            $currentDateTime = (new \DateTime())->format('Y-m-d H:i:s');

            if (Yii::$app->session->isActive) {
                $token = Yii::$app->session->get('usu_token');
                $usu_id =  Yii::$app->session->get('usu_id');
            }
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('post')
                ->addHeaders([
                    'content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token
                ])
                ->setUrl('http://152.70.212.112/reservas')
                ->setContent(Json::encode([

                    "resv_fecha_hora" => $currentDateTime,
                    "resv_fecha_desde" => $fecha_desde,
                    "resv_fecha_hasta" => $fecha_hasta,
                    "resv_usu_id" => $usu_id,
                    "resv_lib_id" => $libro_id

                ]))
                ->send();
            $data= json_decode($response->getContent());
            if ($response->isOk) {

               return 1;
            }
            //errores de validacion de datos
            else if ($response->getStatusCode()==422){
                $messages = []; // Array para almacenar los mensajes

                foreach ($data as $item) {
                    $messages[] = $item->message;
                }
                $retorno = json_encode($messages);
                return $retorno;
            }
            //errores de autorizacion
            else if ($response->getStatusCode()==403){

                return 3;
            }
        } 
        

        //Llamada a la API para crear
        return $this->redirect('site/index');
    }


    public function actionUpdate()
    {
        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        if ($this->request->post()) {
            $libro_id = $_POST['libro_id'];
            $estado = $_POST['estado'];
            $fecha_desde = $_POST['fecha_desde'];
            $fecha_hasta = $_POST['fecha_hasta'];
            $idReserva= $_POST['id_reserva'];
            
            $fecha_desde_convertida = date("Y-m-d", strtotime($fecha_desde));
            $fecha_hasta_convertida = date("Y-m-d", strtotime($fecha_hasta));
            $currentDateTime = (new \DateTime())->format('Y-m-d H:i:s');

            if (Yii::$app->session->isActive) {
                $token = Yii::$app->session->get('usu_token');
                $usu_id =  Yii::$app->session->get('usu_id');
            }
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('put')
                ->addHeaders([
                    'content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])
                ->setUrl('http://152.70.212.112/reservas/update?id='.$idReserva)
                ->setContent(Json::encode([

                    "resv_fecha_hora" => $currentDateTime,
                    "resv_fecha_desde" => $fecha_desde_convertida,
                    "resv_fecha_hasta" => $fecha_hasta_convertida,
                    "resv_usu_id" => $usu_id,
                    "resv_estado" => $estado,
                    "resv_lib_id" => $libro_id

                ]))
                ->send();

            if ($response->isOk) {

                // Decodificar el contenido JSON en un array asociativo 
                //   $data2 = json_decode($response->getContent(), true);
                //    $data2 =$data1['data'];
                //    $data3 = $data2['libro'];

                return $this->redirect(['index-admin']);
            }
        } 
        

        //Llamada a la API para crear
        return $this->redirect(['index-admin']);
    }

    public function actionCancelarReserva()
    {
        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        if ($this->request->post()) {
        //    $libro_id = $_POST['libro_id'];
          
            $idReserva= $_POST['id_reserva'];
          
            $currentDateTime = (new \DateTime())->format('Y-m-d H:i:s');

            if (Yii::$app->session->isActive) {
                $token = Yii::$app->session->get('usu_token');
                $usu_id =  Yii::$app->session->get('usu_id');
            }
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('put')
                ->addHeaders([
                    'content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])
                ->setUrl('http://152.70.212.112/reservas/update?id='.$idReserva)
                ->setContent(Json::encode([

                    "resv_fecha_hora" => $currentDateTime,
                    "resv_usu_id" => $usu_id,
                    "resv_estado" => 'X',
                    

                ]))
                ->send();

            if ($response->isOk) {

                // Decodificar el contenido JSON en un array asociativo 
                //   $data2 = json_decode($response->getContent(), true);
                //    $data2 =$data1['data'];
                //    $data3 = $data2['libro'];

                return $this->redirect(['index']);
            }
        } 
        return $this->redirect(['index']);
    }

    public function actionLevantarLibro()
    {
        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        if ($this->request->post()) {
        //    $libro_id = $_POST['libro_id'];
          
            $idReserva= $_POST['id_reserva'];
          
        //    $currentDateTime = (new \DateTime())->format('Y-m-d H:i:s');

            if (Yii::$app->session->isActive) {
                $token = Yii::$app->session->get('usu_token');
                $usu_id =  Yii::$app->session->get('usu_id');
            }
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('put')
                ->addHeaders([
                    'content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ])
                ->setUrl('http://152.70.212.112/reservas/update?id='.$idReserva)
                ->setContent(Json::encode([

                   
                    "resv_usu_id" => $usu_id,
                    "resv_estado" => 'L',
                    

                ]))
                ->send();

            if ($response->isOk) {

                // Decodificar el contenido JSON en un array asociativo 
                //   $data2 = json_decode($response->getContent(), true);
                //    $data2 =$data1['data'];
                //    $data3 = $data2['libro'];

                return $this->redirect(['index']);
            }
        } 
        return $this->redirect(['index']);
    }
}
