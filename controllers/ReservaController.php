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

    public function actionCreate()
    {
        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        $libro_id = $_POST['libro_id'];
        $fecha_desde = $_POST['fecha_desde'];
        $fecha_hasta = $_POST['fecha_hasta'];

        //Llamada a la API para crear
        return $this->redirect(['index']);
    }

    public function actionCancelarReserva()
    {
        //$usuario_id = $_POST['usuario_id']; todavia no se como se consigue
        $reserva_id = $_POST['id'];

        //Llamada a la API para cancelar
        return $this->redirect(['index']);
    }
}
