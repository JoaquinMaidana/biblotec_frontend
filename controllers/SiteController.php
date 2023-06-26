<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller
{

    private array $usuario;

    private $token;

    private $token2;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        //'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return Response|string
     */
    public function actionIndex()
    {
        if (Yii::$app->session->isActive) {
            $isAdmin = Yii::$app->session->get('usu_tipo_usuario');
        }

        $libroController = new LibroController(Yii::$app->id, Yii::$app);
        $categoriaController = new CategoriaController(Yii::$app->id, Yii::$app);

        $libros = $libroController->runAction('get-libros');
        $categorias = $categoriaController->runAction('get-categorias');

        if (isset($isAdmin) && $isAdmin === 'Administrador') {
            $favoritosController = new FavoritosController(Yii::$app->id, Yii::$app);

            $favoritos = $favoritosController->runAction('get-favoritos');

            return $this->render('index', [
                'libros_Array' => $libros,
                'favoritos' => $favoritos,
                'categorias' => $categorias
            ]);
        }
        return $this->render('index', [
            'libros_Array' => $libros,
            'categorias' => $categorias
        ]); //redirigir a la página de inicio

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        //   if (!Yii::$app->user->isGuest) {
        //       return $this->goHome();
        //   }


        if ($this->request->post()) {
            $usuarioController = new UsuarioController(Yii::$app->id, Yii::$app);
            if (isset($this->usuario)) {
                $user = $this->usuario;
                $token = $this->token;
            } else {
                $url = 'http://152.70.212.112/usuarios';
                $client = new Client();


                $response = $client->createRequest()
                    ->setMethod('post')
                    ->setUrl($url . '/login')
                    ->addHeaders(['content-type' => 'application/x-www-form-urlencoded'])
                    ->setContent(http_build_query([
                        "documento" => Yii::$app->request->post('documento'),
                        "clave" => Yii::$app->request->post('contrasena'),

                    ]))
                    ->send();


                if ($response->isOk) {

                    $respuesta = json_decode($response->getContent(), true);
                    if ($respuesta['codigo'] == '0') {

                        $token = $respuesta['data']['token'];
                        $this->token2 = $token;
                        $user = json_decode($respuesta['data']['datosUsuario'], true);
                    } else {
                        global $mensaje;
                        $mensaje = $respuesta['mensaje'];
                    }
                }
            }


            $session = Yii::$app->session;
            $session->open();
            if (isset($user['usu_id'])) {
                $session->set('usu_id', $user['usu_id']);
            }
            if (isset($this->usuario)) {

                $session->set('usu_documento', $user['documento']);
                $session->set('usu_nombre', $user['nombre']);
                $session->set('usu_apellido', $user['apellido']);
                $session->set('usu_mail', $user['mail']);
                $session->set('usu_clave', $user['clave']);
                $session->set('usu_telefono', $user['telefono']);
                $session->set('usu_tipo_usuario', 'Estudiante');
                $session->set('usu_token', $this->token2);
                $script = <<< JS
                  <script>
                      if (!localStorage.getItem('TokenBibliotec_$user[documento]')) {
                           localStorage.setItem('TokenBibliotec_$user[documento]', '$token');
                      }
                   </script>
                  JS;
            } else {
                $session->set('usu_documento', $user['usu_id']);
                $session->set('usu_documento', $user['usu_documento']);
                $session->set('usu_nombre', $user['usu_nombre']);
                $session->set('usu_apellido', $user['usu_apellido']);
                $session->set('usu_mail', $user['usu_mail']);
                $session->set('usu_clave', $user['usu_clave']);
                $session->set('usu_telefono', $user['usu_telefono']);
                $session->set('usu_token', $this->token2);
                if ($user['usu_tipo_usuario'] == 1) {
                    $session->set('usu_tipo_usuario', 'Administrador');
                } else {
                    $session->set('usu_tipo_usuario', 'Estudiante');
                }
                $script = <<< JS
                  <script>
                      if (!localStorage.getItem('TokenBibliotec_$user[usu_documento]')) {
                           localStorage.setItem('TokenBibliotec_$user[usu_documento]', '$token');
                      }else{
                            localStorage.setItem('TokenBibliotec_$user[usu_documento]', '$token');
                      }
                   </script>
                  JS;
            }



            //   }



            // Agregar el token al local storage utilizando JavaScript
            $libroController = new LibroController(Yii::$app->id, Yii::$app);

            $libros = $libroController->runAction('get-libros');


            // Renderizar la vista 'index' y ejecutar el script de JavaScript
            $this->redirect('Index');
        }



        // Almacenar el tipo de usuario en la variable de sesión
        // Yii::$app->session->set('tipo_usuario', $user['usu_tipo_usuario']);



        return $this->render('login');
    }

    /**
     * Displays homepage.
     *
     * @return Response|string
     */
    public function actionLogout()
    {
        if ($this->request->post()) {


            $session = Yii::$app->session;
            if ($session->isActive) {
                $session->destroy();
                $session->close();
            }
        }
        $libroController = new LibroController(Yii::$app->id, Yii::$app);

        $libros = $libroController->runAction('get-libros');

        return $this->render('index', [
            'libros_Array' => $libros
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRegistro()
    {
        $mensaje = "";
        if ($this->request->post()) {
            $url = 'http://152.70.212.112/usuarios';
            $client = new Client();


            $response = $client->createRequest()
                ->setMethod('post')
                ->setUrl($url . '/registro')
                ->addHeaders(['content-type' => 'application/x-www-form-urlencoded'])
                ->setContent(http_build_query([
                    "documento" => Yii::$app->request->post('usu_documento'),
                    "nombre" => Yii::$app->request->post('usu_nombre'),
                    "apellido" => Yii::$app->request->post('usu_apellido'),
                    "mail" => Yii::$app->request->post('usu_mail'),
                    "clave" => Yii::$app->request->post('usu_clave'),
                    "telefono" => Yii::$app->request->post('usu_telefono'),

                ]))
                ->send();


            if ($response->isOk) {

                $respuesta = json_decode($response->getContent(), true);
                if ($respuesta['codigo'] == '0') {

                    $this->usuario = $respuesta['data']['datosUsuario'];
                    $this->token = $respuesta['data']['token'];
                    return $this->actionLogin();
                } else {
                    global $mensaje;
                    $mensaje = $respuesta['mensaje'];
                }
            } else {
                return false;
            }
        }
        return $this->render('registro');
    }
}
