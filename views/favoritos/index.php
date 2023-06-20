<?php

use app\controllers\FavoritosController;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\httpclient\Client;

/** @var yii\web\View $this */

$this->title = 'Mis libros favoritos';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoritos</title>

<script>
    $(document).ready(function () {
        $('#todas').DataTable();
    });

</script>

</head>
<body>
    <h1><?= Html::encode($this->title) ?></h1>
        
    <div class="col d-flex justify-content-end">
        <?= Html::a('Agregar favoritos', ['libro/index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php 
    /*     let token = localStorage.getItem('TokenBibliotec_50541551');
    if (token) {
    document.getElementById('token-field').value = token;
    console.log(token);
  } else {
    // El contenido de token es nulo o no existe
    // Puedes manejar esta situación según tus necesidades
    console.log('El token no está disponible.');
  }
*/

      
    ?>
    <?= Html::beginForm(['favoritos/updatee'], 'post', ['id' => 'formFav']) ?>
                                    <input type="text" id="id_fav" name="id_fav" value=""></input>
            <?= Html::endForm() ?>
    <table id="todas" class="display compact">
        <thead>
            <tr>
                <th>Titulo</th>
                <th>Portada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>

        
            <?php 

            foreach($favoritos as $favorito){
               
                
                ?>
                <tr>
                    <td><?= $favorito['titulo']; ?></td>
                    <td><button class="btn btn-primary" onclick="$('#modalPortada').modal('show')">Ver portada</button></td>
                    <td><a class='btn btn-warning' onclick="$('#modalCambiarEstado<?=$favorito['fav_id'] ?>').modal('show');">Quitar de favoritos</a></td> 
                </tr>
                    
                <div id="modalPortada" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Portada actual</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                                            <input type="image" id="imagenPortada" src="<?= $favorito['imagen'] ?>"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" onclick="$('#modalPortada').modal('hide');">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                                    
                <div id="modalCambiarEstado<?= $favorito['fav_id']?>" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title">Quitar de favoritos</h5>
                                <label for="estact">
                                  <strong>A : <input style="border: none;"  type="text" value="<?= $favorito['titulo']?>" ></strong>  
                                </label>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary"  onclick="$('#modalCambiarEstado<?=$favorito['fav_id']  ?>').modal('hide');">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick='$(`#id_fav`).val(`<?= $favorito["fav_id"] ?>`);$(`#formFav`).submit()'> Quitar de favoritos</button>
                            </div>
                        </div>
                    </div>
                </div>
                    
            
               
            <?php }?>
        </tbody>
    </table>

</body>
</html>