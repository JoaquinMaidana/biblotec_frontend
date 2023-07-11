<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Reportes';

if (Yii::$app->session->isActive) {      
    $documento = Yii::$app->session->get('usu_documento');             
}

?>

<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-1">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        
    </div>

    <div class="row">
        <div class="col-12">
            <table id="tablaCategorias" class="row-border items table table-condensed hover nowrap">
                <thead>
                    <tr>
                        
                        <th>Nombre</th>
                        
                        <th>Generar</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    

    <div id="modalGenerarReporte" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Generar Reporte</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?= Html::beginForm(['reporte/create'], 'post') ?>
                <input type="text" name="idReporte" id="idReporte"></input>
                <input type="hidden" name="token" value="" >
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-3 text-end">
                                <label>Datos:<span class="text-danger">*<span></label>
                            </div>
                            <div class="col">
                                <textarea name="datos" id="editarNombre" type="text" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" onclick="$('#modalEditarCategoria').modal('hide');">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Generar</button>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>

    


    

    <script>
        $(document).ready(function() {

            $('#tablaCategorias').DataTable({
                data: <?= $reportes_json ?>,
                responsive: true,
                bFilter: false,
                paging: false,
                ordering: false,
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
            },
                columns: [
                    
                    {
                        data: 'nombre'
                    },
                    
                    {
                        data: function(data) {
                            if (data.nombre) {
                                return   "<a class='me-2' onclick='generarReporte(`" + data.idReporte + "`,`" + data.nombre + "`)'><i class='fa-solid fa-bolt'></i></a>";
                            } 
                           
                        }
                    },
                ],
            });
        });

        function generarReporte(id, nombre) {

            $("#idReporte").val(id);
            $("#modalGenerarReporte").modal("show");
        }

       
    </script>

<script> 
        let tokenElements = document.querySelectorAll('[name="token"]');

        if (tokenElements.length > 0) {
        let token = localStorage.getItem('TokenBibliotec_<?=$documento ?>');
        if (token) {
            tokenElements.forEach(function(element) {
            element.value = token;
            });
        } else {
            console.log('El token no está disponible.');
        }
        }

</script>