<?php 
    use yii\bootstrap5\ActiveForm;
    use yii\helpers\Html; 
    use yii\helpers\Url;
    if (Yii::$app->session->isActive) {      
        $documento = Yii::$app->session->get('usu_documento');         
        $id_usuario =  Yii::$app->session->get('usu_id'); 
        var_dump($id_usuario);
    }
?>



<h1>Crear sugerencia</h1>

<?php 

$form = ActiveForm::begin(['action' => ['sugerencias/new'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <label for="sug_sugerencia">
        Texto:&nbsp&nbsp&nbsp&nbsp&nbsp<input type="text" name="sug_sugerencia" id="sug_sugerencia" required>
    </label>
    <br>
    <label for="libro_sug">
        Libro sugerido:&nbsp<input type="text" name="libro_sug"   value="" >
    </label>
    <input type="text" name="token" hidden id="token-field" value="" >
    <br>
    <label for="sug_idusu">
        Usuario:&nbsp<input type="text" name="sug_idusu" id="sug_idusu" disabled value="<?php echo $id_usuario ?>" >
    </label>
    <br>
    <?= Html::submitButton('Eviar sugerencia', ['class' => 'btn btn-success']) ?>
    <button type="button" class="btn btn-dark"> <a class="nav-link" href="<?= Url::toRoute(['sugerencias/index']); ?>">Cancelar</a></button>
   
<?php ActiveForm::end(); ?>
   


<script> 
    let token = localStorage.getItem('TokenBibliotec_<?=$documento ?>');
    if (token) {
    document.getElementById('token-field').value = token;
  } else {
    // El contenido de token es nulo o no existe
    // Puedes manejar esta situación según tus necesidades
    console.log('El token no está disponible.');
  }

</script>