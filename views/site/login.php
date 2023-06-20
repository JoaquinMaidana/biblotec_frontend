<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */


?>

<style>
    .marco {
        position: absolute;
        top: 45%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40%;
        padding: 20px;
    }
</style>

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-10 justify-content-center">
            <div class="container-fluid">
                <?php $form = ActiveForm::begin(['action' => ['site/login'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="row justify-content-center">
                    <div class="col-10 text-center">
                        <h1>Iniciar Sesión</h1>
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <div class="col text-center">
                            <h5>Usuario</h5>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-10 text-center">
                            <?= Html::textInput('documento', null, ['class' => 'form-control', 'maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <div class="col text-center">
                            <h5>Contraseña</h5>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-10 text-center">
                            <?= Html::passwordInput('contrasena', null, ['class' => 'form-control', 'maxlength' => true]) ?>
                        </div>
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <div class="col-10 text-center d-grid gap-2">
                            <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <div class="row mt-4 justify-content-center">
                        <div class="col-10 text-center d-grid gap-2">
                            <?= Html::a('Registrarse', ['site/registro'], ['class' => 'btn btn-secondary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>