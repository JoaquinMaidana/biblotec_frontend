<?php

namespace app\controllers;

use yii\web\Controller;
use yii\httpclient\Client;

class ReservaController extends Controller
{
    public function actionIndex()
    {

        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        $usuario_id = 1; //Borrar despues

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/reservas?resv_usu_id=' . $usuario_id)
            ->send();

        $reservas = json_decode($response->getContent());
        $reservaLibro = array();
        foreach ($reservas as $reserva) {
            $index = array();
            $index['reserva'] = $reserva;
            $index['libro'] = LibroController::findLibro($reserva->resv_lib_id);
            array_push($reservaLibro, $index);
        }

        return $this->render('index', [
            'reservasLibros' => $reservaLibro
        ]);
    }

    public function actionCreate($isbn="")
    {
        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        if ($this->request->post()) {
            $libro_id = $_POST['libro_id'];
            $fecha_desde = $_POST['fecha_desde'];
            $fecha_hasta = $_POST['fecha_hasta'];
        }
        else{
             $client = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
            //    ->setUrl('http://localhost/proyectos%20php/bibliotec_backend/web/libros/obtener-libros')
                ->setUrl('http://152.70.212.112/libros/obtener-libro?isbn='.$isbn)
                ->send();

            if ($response->isOk) {
                
                // Decodificar el contenido JSON en un array asociativo 
                $data2 = json_decode($response->getContent(), true);
            //    $data2 =$data1['data'];
                $data3 = $data2['libro'];
                
                return $this->render('realizarReserva',[
                    'libro' => $data3
                ]);
            
            }
        }

        //Llamada a la API para crear
        return $this->render('realizarReserva');
    }

    public function actionCancelarReserva()
    {
        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        $reserva_id = $_POST['id'];

        //Llamada a la API para cancelar
        return $this->redirect(['index']);
    }
}
