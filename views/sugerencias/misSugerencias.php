<?php 
namespace app\controllers;

use Yii;
    if(\Yii::$app->session->isActive){
                            
    
    $usu_id = Yii::$app->session->get('usu_id');
    $isAdmin = Yii::$app->session->get('usu_tipo_usuario');
    }
?>


<!DOCTYPE html>
<html lang="es-UY">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis sugerencias</title>
    <?php 
        use yii\helpers\Html;
        use yii\helpers\Url;
       // $sugerencias = json_decode($sugerencias); 
       // var_dump($sugerencias);exit;
    ?>
    <script>
    $(document).ready(function () {
    $('#missugerencias').DataTable({
        language: {
                "sEmptyTable": "No hay datos disponibles en la tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing": "Procesando...",
                "sSearch": "Buscar:",
                "sZeroRecords": "No se encontraron resultados",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
    });
    });
</script>
</head>
<body>
    <h1>Mis sugerencias</h1>
    <button type="button" class="btn btn-dark"> <a class="nav-link" href="<?= Url::toRoute(['sugerencias/index']); ?>">Volver</a></button>
    <table id="missugerencias" class="display compact">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Texto de sugerencia</th>
                    <th>Vigente</th>
                    <th>Usuario que realiza</th>
                    <th>Fecha realizacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
               
                if ($sugerencias != ""   ){
                
                    foreach($sugerencias as $sugerencia){
                         if(isset($isAdmin) && $usu_id==$sugerencia['sug_usu_id']){
                        //var_dump($usu_id);exit;
                         //if($sugerencia->sug_usu_id == Yii::$app->user->identity->id){
                ?>
                            <tr>
                                <td><?= $sugerencia['sug_id']; ?></td>
                                <td><?= $sugerencia['sug_sugerencia']; ?></td>
                                <td><?= $estado = $sugerencia['sug_vigente']=='S' ? 'Activa' : 'Revisada'; ?></td>
                                <td><?= $sugerencia['sug_usu_id']; ?></td>
                                <td><?= $sugerencia['sug_fecha_hora']; ?></td>
                                <td><a class='btn btn-warning' onclick="$('#modalCambiarEstado<?=$sugerencia['sug_id'] ?>').modal('show');">Cambiar estado</a></td>
                                
                            </tr>
                            <?= Html::beginForm(['sugerencias/update'], 'post') ?>
                                            
                                <div id="modalCambiarEstado<?= $sugerencia['sug_id']?>" class="modal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cambiar de estado</h5>
                                                <label for="estact">
                                                        Estado actual: <input type="text" name="estact" value="<?= $estado = $sugerencia['sug_vigente']=='S' ? 'Activa' : 'Revisada'; ?>" disabled>
                                                </label>
                                                <label for="nuevoEstado">Pasar a estado: 
                                                    <select name="nuevoEstado">
                                                        <?php if ($sugerencia['sug_vigente']=='S'){
                                                            echo '<option value="N">Revisada</option>'; 
                                                        } else { 
                                                            echo '<option value="S">Activa</option>';
                                                        } ?>
                                                    </select>
                                                </label>
                                                <input type="hidden" name="id" value="<?= $sugerencia['sug_id'];?>"></input>
                                                <input type="hidden" name="sug_sugerencia" value="<?= $sugerencia['sug_sugerencia'];?>"></input>
                                                <input type="hidden" name="sug_idusu" value="<?= $sugerencia['sug_usu_id'];?>"></input>
                                                <input type="hidden" name="sug_fecha" value="<?= $sugerencia['sug_fecha_hora'];?>"></input>
                                            </div>
                                            <div class="modal-body">
                                                <div class="container-fluid">
                                                    <div class="row justify-content-center">
                                                        <div class="col" id="textoModalDesactivar">
                                                        <p>Confirmar cambio de estado</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-primary"  onclick="$('#modalCambiarEstado<?=$sugerencia['sug_id'] ?>').modal('hide');">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?= Html::endForm() ?>
                <?php
                            }
                        }
                    }
                //}
                ?>

            </tbody>
    </table>
    
</body>
</html>