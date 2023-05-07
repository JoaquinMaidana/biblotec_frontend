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

        return $this->render('index', [
            'libros' => $response->getContent()
        ]);
    }

    public function actionCreate()
    {
        if (isset($_POST['titulo'])) {
            $titulo = $_POST['titulo'];
            $autores = $_POST['autor'];
            $edicion = $_POST['edicion'];
            $fecha = $_POST['fecha'];
            $idioma = $_POST['idioma'];
            $descripcion = $_POST['descripcion'];
            $portada = $_FILES['portada'];
            $url = $_POST['url'];
            $puntuacion = $_POST['puntuacion'];
            $subcategoria = $_POST['subcategoria'];
            $disponible = $_POST['disponible'];
            $novedad = $_POST['novedad'];
            $stock = $_POST['stock'];

            //Llamada a la API para crear
            return $this->redirect(['index']);
        } else {

            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl('http://localhost:3000/sub_categorias')
                ->send();

            return $this->render('crearActualizarLibro', ['actualizar' => 'N', 'sub_categorias' => json_decode($response->getContent()), 'action' => 'libro/create']);
        }
    }

    public function actionUpdate()
    {
        $id = $_POST['id'];

        if (isset($_POST['titulo'])) {
            $titulo = $_POST['titulo'];
            $autores = $_POST['autor'];
            $edicion = $_POST['edicion'];
            $fecha = $_POST['fecha'];
            $idioma = $_POST['idioma'];
            $descripcion = $_POST['descripcion'];
            $portada = $_FILES['portada']; //Si no se modifico la portada llega vacio
            $url = $_POST['url'];
            $puntuacion = $_POST['puntuacion'];
            $subcategoria = $_POST['subcategoria'];
            $disponible = $_POST['disponible'];
            $novedad = $_POST['novedad'];
            $stock = $_POST['stock'];

            //Llamada a la API para actualizar
            return $this->redirect(['index']);
        } else {

            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl('http://localhost:3000/sub_categorias')
                ->send();

            $libro = $this->findLibro($id);

            return $this->render('crearActualizarLibro', ['actualizar' => 'S', 'sub_categorias' => json_decode($response->getContent()),  'action' => 'libro/update', 'libro' => $libro]);
        }
    }

    public function actionDelete()
    {
        $id = $_POST['id'];

        return $this->redirect(['index']);
    }


    public function actionView()
    {
        $id = $_POST['id'];

        $libro = $this->findLibro($id);
        return $this->render('detalleLibro', [
            'libro' => $libro
        ]);
    }

    public function actionCompletado()
    {

        $isbn = $_POST['isbn'];

        $libro = ""; //Llamada a la API para recibir los datos

        return $libro;
    }

    protected function findLibro($idlibros) //Borrar una vez que se tenga la API
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
            return $libro = "";
        }
    }
}
