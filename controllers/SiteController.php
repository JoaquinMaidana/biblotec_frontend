<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;

class SiteController extends Controller
{



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

        $libroController = new LibroController(Yii::$app->id, Yii::$app);

        $libros = $libroController->runAction('get-libros');
        return $this->render('index', [
            'libros_Array' => $libros
        ]); //redirigir a la página de inicio

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if ($this->request->post()) {
            $usuarioController = new UsuarioController(Yii::$app->id, Yii::$app);
            if (isset($_POST['documento'])) {
                $user = $usuarioController->findUser($_POST['documento']);
            }


            if ($user['id'] == $_POST['documento'] && $user['usu_clave'] == $_POST['contrasena']) { //esto lo hace el back pero por mientras



                $session = Yii::$app->session;
                $session->open();

                $session->set('usu_id', $user['usu_id']);
                $session->set('usu_documento', $user['id']);
                $session->set('usu_nombre', $user['usu_nombre']);
                $session->set('usu_apellido', $user['usu_apellido']);
                $session->set('usu_mail', $user['usu_mail']);
                $session->set('usu_clave', $user['usu_clave']);
                $session->set('usu_telefono', $user['usu_telefono']);
                $session->set('usu_tipo_usuario', $user['usu_tipo_usuario']);



                //    $client = new Client();
                //    $response = $client->createRequest()
                //        ->setMethod('get')
                //        ->setUrl('http://localhost:3000/libros')
                //        ->send();

                //    if ($response->isOk) {

                // Decodificar el contenido JSON en un array asociativo 
                //        $data = json_decode($response->getContent(), true);
                //        $libros_array = array();
                //        $string = json_encode($data);
                //     var_dump($string);




                $script = <<< JS
                  <script>
                      if (!localStorage.getItem('TokenBibliotec_$user[id]')) {
                           localStorage.setItem('TokenBibliotec_$user[id]', '$user[usu_token]');
                      }
                   </script>
                  JS;



                //   }



                // Agregar el token al local storage utilizando JavaScript
                $libroController = new LibroController(Yii::$app->id, Yii::$app);

                $libros = $libroController->runAction('get-libros');


                // Renderizar la vista 'index' y ejecutar el script de JavaScript
                return $this->render('index', [
                    'libros_Array' => $libros
                ]) . $script;
            }



            // Almacenar el tipo de usuario en la variable de sesión
            // Yii::$app->session->set('tipo_usuario', $user['usu_tipo_usuario']);

        }

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


        return $this->render('index');
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
}
