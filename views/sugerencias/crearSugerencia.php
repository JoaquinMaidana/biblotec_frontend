<!DOCTYPE html>
<html lang="es-UY">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear sugerencia</title>
    <?php  use yii\bootstrap5\ActiveForm;
           use yii\helpers\Html; 
           use yii\helpers\Url;?>
</head>
<body>
<h1>Crear sugerencia</h1>

<?php 
$form = ActiveForm::begin(['action' => ['sugerencias/new'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <label for="sug_sugerencia">
        Texto:<input type="text" name="sug_sugerencia" id="sug_sugerencia" required>
    </label>

    <label for="sug_idusu">
        Usuario:<input type="text" name="sug_idusu" id="sug_idusu" disabled value="<?= Yii::$app->user->identity->id ?>" >
    </label>

    <?= Html::submitButton('Eviar sugerencia', ['class' => 'btn btn-success']) ?>
    <button type="button" class="btn btn-dark"> <a class="nav-link" href="<?= Url::toRoute(['sugerencias/index']); ?>">Cancelar</a></button>
   
<?php ActiveForm::end(); ?>
   
</body>
</html>