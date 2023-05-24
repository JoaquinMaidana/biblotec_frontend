<?php


use PHPUnit\Framework\Constraint\IsEmpty;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;


/** @var yii\web\View $this */

$this->title = 'Libros favoritos';
$this->params['breadcrumbs'][] = $this->title;

?>

<!DOCTYPE html>
<html lang="es-UY">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros favoritos</title>

<script>
    $(document).ready(function () {
    $('#todas').DataTable();
    });
</script>   

<style> 

    .btn {
        padding: 10px;
        margin: 10px;
    }
    img {
        width: 50px;   
    }
    
</style>
</head>
<body>
    <div class="favoritos-index">
    
        <?php $favoritos = json_decode($favoritos); $libros = json_decode($libros);  ?>

        <table id="todas" class="display compact">
            <thead>
                <tr>
                    <td><h1><?= Html::encode($this->title) ?></h1></td>
                    <td><input type="button" class="btn btn-primary" onclick="history.back()" value="Volver"></td>      
                <tr>
            </thead>
            <tbody> 
                <?= Html::beginForm(['favoritos/update'], 'post', ['id' => 'formFav']) ?>
                                        <input type="hidden" name="id" id="idLibroView"></input>
                                        <input type="hidden" name="idlibro" id="id_lib" value=""></input>
                                        <input type="hidden" name="idusu" value="<?= Yii::$app->session->get('usu_documento') ?>" ></input>
                                        <input type="hidden" name="estado" value="<?= 0 ?>"></input>
                                        <input type="hidden" name="idfav" id="id_fav" value=""></input>
                <?= Html::endForm() ?>
                <?php
                //var_dump($favoritos);exit;
                
                foreach($favoritos as $fav){
                    
                    
                    if ($fav->fav_usu_id == Yii::$app->session->get('usu_documento') && $fav->fav_estado > 0){ //si el id de usuario de favoritos es igual al id del usuario logueado
                        
                        foreach($libros as $libro){
                            if($libro->id == $fav->fav_lib_id){//si el id del libro de favoritos es igual al id de libro de libros
                            ?>
                                <tr>
                                    <td><p><?=$libro->lib_titulo?>
                                    <img src="<?=$libro->lib_imagen ?>" alt="https://upload.wikimedia.org/wikipedia/commons/0/0a/No-image-available.png"></p> </td>
                                    <td>
                                    
                                        <?= Html::a('Ver mas', ['libro/view', 'id2'=> $libro->id], ['class' => 'btn btn-success']) ?> 
                                        <?php $array = ['idlibro'=> $libro->id, 'libid'=>$libro->id, 'idusu'=>$fav->fav_usu_id, 'titulo'=>$libro->lib_titulo];
                                     //   var_dump($array) ?>
                                        <a class='btn btn-warning' onclick="$('#modalQuitarFavorito<?=$libro->id ?>').modal('show');">Quitar</a>
                                        
                                    
                                    </td>
                                </tr>
                                
                                <div id="modalQuitarFavorito<?= $libro->id?>" class="modal" tabindex="-1">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Desactivar libro</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>
                                        
                                       
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="row justify-content-center">
                                                    <div class="col" id="textoModalDesactivar">
                                                    <p>¿Desea quitar el libro <?= "<strong> ".$libro->lib_titulo."</strong> " ?> de favoritos?</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-primary"  onclick="$('#modalQuitarFavorito<?=$libro->id ?>').modal('hide');">Cancelar</button>
                                            <button type="submit" class="btn btn-primary" onclick='$(`#id_lib`).val(`<?= $libro->id?>`);$(`#id_fav`).val(`<?= $fav->id?>`);$(`#formFav`).submit()'>Confirmar</button>
                                        </div>
                                </div>
                            </div>  
                            </div>  
                           
                        <?php
                         }
                        }
                    };
                };
                ?>
            </tbody>
        </table>   
    </div>

</body>

</html>