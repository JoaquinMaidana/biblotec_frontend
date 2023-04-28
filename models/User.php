<?php

namespace app\models;
use app\controllers\UsuarioController;
use Yii;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
      public $usu_id;
      public $id;
      public $usu_nombre;
      public $usu_apellido;
      public $usu_mail;
      public $usu_clave;
      public $usu_telefono;
      public $usu_activo;
      public $usu_tipo_usuario;
      public $usu_habilitado;
      public $usu_token;

      public $authKey;

    
     
    private static $users = [
        '40000005' => [
            "id" => "40000005",
            "usu_nombre" => "Matias",
            "usu_apellido"=> "Fernandez",
            "usu_mail"=> "estudiante@utec.com",
            "usu_clave" => "estudiante",
            "usu_telefono" => "1122334456",
            "usu_activo"=> "S",
            "usu_tipo_usuario"=> "Estudiante",
            "usu_habilitado"=> "S",
            "usu_token"=> "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxIiwiFWF0IjoxNjIyNjA5NTgxLCJleHAiOjE2MjI2MTMxODF9.H4v9D21MdrdN81FYIZeI-w5KjP5oRcOlf5I5LTHy-dB",
            "authKey" => "test101key6"
        ]
    ];
    

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $usuarioController = new UsuarioController(Yii::$app->id, Yii::$app);

        $user = $usuarioController->findUser($id);

        return new static($user);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByDocumento($usu_documento)
    {
        $usuarioController = new UsuarioController(Yii::$app->id, Yii::$app);

        $user = $usuarioController->findUser($usu_documento);

        if (strcasecmp($user['id'], $usu_documento) === 0) {
            return new static($user);
        }
    

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    
    /**
     * {@inheritdoc}
     */

    public function getTipoUsuario()
    {
        return $this->usu_tipo_usuario;
    }

    

    /**
     * {@inheritdoc}
     */

    
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */


    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->usu_clave === $password;
    }
}
