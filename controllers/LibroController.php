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
            'libros' => $string,
            'libros_Array' => $libros_array
        ]);
    }

    public function actionCreate()
    {
        //primero  consulto si la peticion vino por post
        if ($this->request->post()) {
            $this->save();
        }

        $categoriaController = new CategoriaController(Yii::$app->id, Yii::$app);

        $categorias = $categoriaController->runAction('get-categorias');

        $subCategoriaController = new SubcategoriaController(Yii::$app->id, Yii::$app);

        $subcategorias = $subCategoriaController->runAction('get-subcategorias');

        
        return $this->render('crearLibro', [
            'categorias' => $categorias,
            'sub_categorias' => $subcategorias,
        ]);
    }
    public function actionCompletado($isbn)
    {   //conexion a la api para autocompletar el formulario de los libros
     
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('https://openlibrary.org/api/books?bibkeys=ISBN:'.$isbn.'&jscmd=details&format=json')
            ->send();
            
        if ($response->isOk) {
            $data = json_decode($response->getContent(), true); 
            if (!empty($data)) {
                $datoslibro = $data['ISBN:'.$isbn];
                $lib_imagen = "";
                $response_imagen = $client->createRequest()//obtener imagen
                ->setMethod('get')
                ->setUrl('https://openlibrary.org/api/books?bibkeys=ISBN:'.$isbn.'&jscmd=data&format=json')
                ->send();

                if($response_imagen->isOk){
                    $data_imagen = json_decode($response_imagen->getContent(), true); 
                    $lib_imagen = $data_imagen['ISBN:'.$isbn]['cover']['large'];
                }
                
                //Para guardar los autores independiente de cuantos sean
                foreach ($datoslibro['details']['authors'] as $autor) {
                    $nombres_autores[] = $autor['name']; // añadir el nombre del autor al array de nombres de autores
                  }
                  
                  $autores_concatenados = implode(', ', $nombres_autores); // unir los nombres de los autores con comas
                //idiomas
                
                  
                $libro=[
                    "lib_isbn" => $isbn,
                    "lib_titulo"=> $datoslibro['details']['title'],
                    "lib_descripcion"=> isset($datoslibro['details']['description']) ? $datoslibro['details']['description'] : '',
                    "lib_imagen"=> $lib_imagen,
                    "lib_autores"=> $autores_concatenados,
                    "lib_url"=>$datoslibro['info_url'],
                    "lib_edicion"=> "1",
                    "lib_fecha_lanzamiento"=> $datoslibro['details']['publish_date'],
                    "lib_idioma"=> "Inglés",
                ];

            } else {
                $libro=$data;
            }
        } else {
            $libro="";
        }

        $categoriaController = new CategoriaController(Yii::$app->id, Yii::$app);

        $categorias = $categoriaController->runAction('get-categorias');

        $subCategoriaController = new SubcategoriaController(Yii::$app->id, Yii::$app);

        $subcategorias = $subCategoriaController->runAction('get-subcategorias');

            
        return $this->render('crearLibro', [
            'libro' => $libro,
            'categorias' => $categorias,
            'sub_categorias' => $subcategorias,
        ]);
    }

    public function actionUpdate($idlibros)
    {
        $libro = $this->findLibro($idlibros);

        if ($this->request->post()) {
            $this->save('PUT');
        }

        $categoriaController = new CategoriaController(Yii::$app->id, Yii::$app);

        $categorias = $categoriaController->runAction('get-categorias');

        $subCategoriaController = new SubcategoriaController(Yii::$app->id, Yii::$app);

        $subcategorias = $subCategoriaController->runAction('get-subcategorias');

        return $this->render('modificarLibro', [
            'libro' => $libro,
            'categorias' => $categorias,
            'sub_categorias' => $subcategorias,
        ]);
    }

    public function actionDelete($idlibros)
    {
        $libro = $this->findLibro($idlibros);
        $this->delete($libro['id']);
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
                "lib_isbn"=>Yii::$app->request->post('lib_isbn'),
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
                "lib_novedades"=>Yii::$app->request->post('lib_novedades')== '1' ? 'Si' : 'No',
                "lib_idioma" =>Yii::$app->request->post('lib_idioma'),
                "lib_disponible"=>Yii::$app->request->post('lib_disponible')== '1' ? 'Si' : 'No',
                "lib_vigente"=>Yii::$app->request->post('lib_vigente')== '1' ? 'Si' : 'No',
                "lib_puntuacion"=>"0.0",
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
