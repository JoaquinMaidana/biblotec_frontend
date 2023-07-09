<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;
use yii\filters\AccessControl;
class SubcategoriaController extends Controller
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create','index','update','delete','save'],
                'rules' => [
                    [
                        'actions' => ['create','index','update','delete','save'],
                        'allow' => true,
                        //'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->session->get('usu_tipo_usuario') != 'Administrador') {
                                return $this->redirect(['site/index']);
                            }
                            return true;
                        },
                       
                        
                    ],
                ],
            ],
         
        ];
    }
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
            ->setUrl('http://152.70.212.112/sub-categorias/listado')
            ->addHeaders(['Authorization' => 'Bearer ' . 'user'])
            ->send();

            $categoriaController = new CategoriaController(Yii::$app->id, Yii::$app);

            $categorias = $categoriaController->runAction('get-categorias2');
            $categorias_array = $data = json_decode($categorias, true);

            $dataSubCategorias = json_decode($response->getContent(), true);
            $subcategorias = $dataSubCategorias['data'];
            $subcategorias_json = json_encode($subcategorias);

        return $this->render('index', [
            'sub_categorias' => $subcategorias_json,
            'categorias' => $categorias_array,
        ]);
    }
    public function actionGetSubcategorias(){
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/sub_categorias')
            ->send();

        $data = json_decode($response->getContent(), true);
        $categoria_array = array();
        
        return $data;
    }

    public function actionGetSubcategoriasporid($id_categoria){
        $client = new Client();
        
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://152.70.212.112:3000/sub_categorias?id='.$id_categoria)
            ->send();

        $categoriasHijas = json_decode($response->getContent(), true);
        $categoria_array = array();
        
        return $response->getContent();
    }

    public function actionCreate()
    {   
        if ($this->request->post()) {
            $nombre = $_POST["nombre"];
            $categoria = $_POST["categoria"];
            $this->save();
        }

        return $this->redirect(['index']);
    }

    public function actionUpdate()
    {
        if ($this->request->post()) {
            $id = $_POST["id"];
            $nombre = $_POST["nombre"];
            $this->save('PUT');
        }

        return $this->redirect(['index']);
       //$categoria = $_POST["categoria"];
    }

    public function actionDelete()
    {
        $id = $_POST["id"];
        if (Yii::$app->session->isActive) {
            $token = Yii::$app->session->get('usu_token');
        }
            $client = new Client();
            $response = $client->createRequest()
            ->setMethod('put')
            ->setUrl('http://152.70.212.112/sub-categorias/delete?id='.$id)
            ->addHeaders(['content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
            ])->send();

            return $this->redirect(['index']);

    }

    public function actionActivate()
    {
        $id = $_POST["id"];
        if (Yii::$app->session->isActive) {
            $token = Yii::$app->session->get('usu_token');
        }
            $client = new Client();
            $response = $client->createRequest()
            ->setMethod('put')
            ->setUrl('http://152.70.212.112/sub-categorias/activar?id='.$id)
            ->addHeaders(['content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
            ])->send();

            return $this->redirect(['index']);

    }


    protected function save($httpMethod='post')
    {
        $url = 'http://152.70.212.112/sub-categorias';
        $client = new Client();
        if (Yii::$app->session->isActive) {
            $token = Yii::$app->session->get('usu_token');
        }
        if ($httpMethod === 'PUT') {
            $url .= '/update';
            $response = $client->createRequest()
            ->setMethod('put')
            ->setUrl($url)
            ->addHeaders(['content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
            
            
            ])
            ->setContent(Json::encode([   
                "nombre" => Yii::$app->request->post('nombre'),
                "id" => Yii::$app->request->post('id'),      
            ]))
            ->send();
        } else {
            $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl($url.'/create')
            ->addHeaders(['content-type' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
            
            
            ])
            ->setContent(Json::encode([   
                "nombre" => Yii::$app->request->post('nombre'),
                "id_categoria" => Yii::$app->request->post('categoria'),
                "vigente" => 'S',      
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
