<?php

use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */


$this->registerJsFile('@web/scanner/scanner.js');
$this->registerCssFile('@web/scanner/scanner.css');

if (isset($categorias)) {
  $categorias_string = json_encode($categorias);
}

?>
<style>
  .titulo {
    font-family: inherit;

  }

  label,
  p {
    color: white;
  }
</style>

<?php if (isset($libro) && !empty($libro) && $isGet === 'No') : ?>

  <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
    <strong>Libro encontrado!</strong> Título: <?php echo $libro['lib_titulo']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <div class="d-flex justify-content-center">
    <img src="<?php echo  $libro['lib_imagen'] ?>" class="img-fluid shadow-lg border" alt="imagen del libro">
  </div>

<?php elseif (isset($libro) && count($libro) === 0 && $isGet === 'No') : ?>
  <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
    <strong>Libro no encontrado!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

<?php endif; ?>

<?php if (isset($mensaje) && !empty($mensaje)) : ?>
  <div class="alert alert-primary alert-dismissible fade show mb-3" role="alert">
    <strong>Mensaje</strong> Descripcion: <?php echo $mensaje; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col text-end">
      <button id="btn-scanner" class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseScanner" aria-expanded="false" aria-controls="collapseScanner">
        Mostrar Escaner
      </button>
    </div>
  </div>

  <div class="row mt-3 justify-content-end">
    <div class="col-3 text-end">
      <label>Ingresar ISBN manualmente:</label>
    </div>
    <div class="col-2">
      <input id="txt-code" type="text" class="form-control">
    </div>
    <div class="col-auto">
      <button id="btn-code" class="btn btn-primary" onclick="completarCampos()">Completar campos</button>
    </div>
  </div>
  <div class="row mt-3 justify-content-center">

    <hr>

    <div class="col-6">
      <div class="collapse" id="collapseScanner">
        <div class="controls">
          <fieldset class="input-group">
            <button class="stop">Stop</button>
          </fieldset>
          <fieldset class="reader-config-group">
            <label>
              <span>Barcode-Type</span>
              <select name="decoder_readers">
                <option value="code_128">Code 128</option>
                <option value="code_39">Code 39</option>
                <option value="code_39_vin">Code 39 VIN</option>
                <option value="ean" selected="selected">EAN</option>
                <option value="ean_extended">EAN-extended</option>
                <option value="ean_8">EAN-8</option>
                <option value="upc">UPC</option>
                <option value="upc_e">UPC-E</option>
                <option value="codabar">Codabar</option>
                <option value="i2of5">Interleaved 2 of 5</option>
                <option value="2of5">Standard 2 of 5</option>
                <option value="code_93">Code 93</option>
              </select>
            </label>
            <label>
              <span>Resolution (width)</span>
              <select name="input-stream_constraints">
                <option value="320x240">320px</option>
                <option value="640x480">640px</option>
                <option value="800x600">800px</option>
                <option selected="selected" value="1280x720">1280px</option>
                <option value="1600x960">1600px</option>
                <option value="1920x1080">1920px</option>
              </select>
            </label>
            <label>
              <span>Patch-Size</span>
              <select name="locator_patch-size">
                <option value="x-small">x-small</option>
                <option value="small">small</option>
                <option selected="selected" value="medium">medium</option>
                <option value="large">large</option>
                <option value="x-large">x-large</option>
              </select>
            </label>
            <label>
              <span>Half-Sample</span>
              <input type="checkbox" checked="checked" name="locator_half-sample" />
            </label>
            <label>
              <span>Workers</span>
              <select name="numOfWorkers">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option selected="selected" value="4">4</option>
                <option value="8">8</option>
              </select>
            </label>
            <label>
              <span>Camera</span>
              <select name="input-stream_constraints" id="deviceSelection">
              </select>
            </label>
            <label style="display: none">
              <span>Zoom</span>
              <select name="settings_zoom"></select>
            </label>
            <label style="display: none">
              <span>Torch</span>
              <input type="checkbox" name="settings_torch" />
            </label>
          </fieldset>
        </div>
        <div id="result_strip">
          <ul class="thumbnails"></ul>
          <ul class="collector"></ul>
        </div>
        <div id="interactive" class="viewport"></div>
        </section>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-6">
      <?php $form = ActiveForm::begin(['action' => ['libro/create'], 'options' => ['enctype' => 'multipart/form-data']]); ?>
      <div class="row justify-content-center">
        <div class="col-3 text-end">
          <label>ISBN:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textInput('lib_isbn', isset($libro) && !empty($libro) ? $libro['lib_isbn'] : null, ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Título:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textInput('lib_titulo', isset($libro) && !empty($libro) ? $libro['lib_titulo'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Autor/es:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textInput('lib_autores', isset($libro) && !empty($libro) ? $libro['lib_autores'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>

        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Edición:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textInput('lib_edicion', isset($libro) && !empty($libro) ? $libro['lib_edicion'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Fecha de lanzamiento:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textInput('lib_fecha_lanzamiento', isset($libro) && !empty($libro) ? $libro['lib_fecha_lanzamiento'] : null, ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Idioma:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textInput('lib_idioma', isset($libro) && !empty($libro) ? $libro['lib_idioma'] : null, ['class' => 'form-control', 'maxlength' => true]) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Descripción:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textarea('lib_descripcion', isset($libro) && !empty($libro) ? $libro['lib_descripcion'] : null, ['rows' => 6, 'class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Portada:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textInput('lib_imagen', isset($libro) && !empty($libro) ? $libro['lib_imagen'] : null, ['class' => 'form-control']) ?>
        </div>

      </div>



      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Categoría:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::dropDownList(
            'lib_categoria',
            isset($libro) && !empty($libro) ? $libro['lib_categoria'] : null,
            \yii\helpers\ArrayHelper::map($categorias, 'id', 'nombre'),
            ['id' => 'categoria-dropdown', 'prompt' => 'Seleccione una categoría', 'class' => 'form-control', 'required' => true]
          ) ?>

        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Sub Categoría:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::dropDownList('lib_sub_categoria', isset($libro) && !empty($libro) ? $libro['lib_sub_categoria'] : null, [], ['prompt' => 'Seleccione una subcategoría', 'class' => 'form-control', 'required' => true, 'id' => 'subcategoria']) ?>
        </div>
      </div>


      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Disponible:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::dropDownList('lib_disponible', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Novedad:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::dropDownList('lib_novedades', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Vigente:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::dropDownList('lib_vigente', '1', [0 => 'No', 1 => 'Sí'], ['class' => 'form-control']) ?>
        </div>
      </div>


      <div class="row mt-3 justify-content-center">
        <div class="col-3 text-end">
          <label>Stock:<span class="text-danger">*<span></label>
        </div>
        <div class="col-9">
          <?= Html::textInput('lib_stock', 1, ['class' => 'form-control']) ?>
        </div>
      </div>

      <div class="row mt-3 justify-content-end">
        <div class="col-auto">
          <a href="<?= Url::toRoute(['libro/index']); ?>" class="btn btn-outline-primary">Cancelar</a>
        </div>
        <div class="col-auto">
          <?= Html::submitButton('Crear', ['class' => 'btn btn-primary']) ?>
        </div>
      </div>

    </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>


<script>
  function completarCampos() {
    let isbn = $("#txt-code").val();
    let url = '<?= Yii::$app->urlManager->createUrl(['libro/completado', 'isbn' => '']) ?>' + encodeURIComponent(isbn);
    window.location.href = url;
  }

  const btnToggle = document.getElementById('btn-scanner');

  btnToggle.addEventListener('click', function() {
    const isExpanded = btnToggle.getAttribute('aria-expanded') === 'true';

    if (isExpanded) {
      btnToggle.innerHTML = 'Ocultar Escaner';
    } else {
      btnToggle.innerHTML = 'Mostrar Escaner';
    }
  });

  var categoriasSubcategorias = <?php echo $categorias_string ?>;

  var categoriaDropdown = document.getElementById("categoria-dropdown");
  var subcategoriaDropdown = document.getElementById("subcategoria");

  // Función para llenar el dropdown de subcategorías
  function llenarSubcategorias() {
    var categoriaId = parseInt(categoriaDropdown.value);

    // Limpiar el dropdown de subcategorías
    subcategoriaDropdown.innerHTML = "";

    // Buscar la categoría seleccionada en el arreglo
    var categoria = categoriasSubcategorias.find(function(c) {
      return c.id === categoriaId;
    });

    if (categoria) {
      // Rellenar el dropdown de subcategorías
      for (var i = 0; i < categoria.subCategorias.length; i++) {
        var subcategoria = categoria.subCategorias[i];
        var option = document.createElement("option");
        option.value = subcategoria.id;
        option.text = subcategoria.nombre;
        subcategoriaDropdown.appendChild(option);
      }
    }
    var libroSubCategoria = <?= isset($libro) && !empty($libro) ? $libro['lib_sub_categoria'] : 'null' ?>;
    if (libroSubCategoria !== null) {
      subcategoriaDropdown.value = libroSubCategoria;
    }
  }

  // Evento de cambio de selección de categoría
  categoriaDropdown.addEventListener("change", llenarSubcategorias);

  // Llamar a la función para llenar el dropdown por primera vez
  llenarSubcategorias();
</script>

<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script >

$(function() {
    var resultCollector = Quagga.ResultCollector.create({
        capture: true,
        capacity: 20,
        blacklist: [{
            code: "WIWV8ETQZ1", format: "code_93"
        }, {
            code: "EH3C-%GU23RK3", format: "code_93"
        }, {
            code: "O308SIHQOXN5SA/PJ", format: "code_93"
        }, {
            code: "DG7Q$TV8JQ/EN", format: "code_93"
        }, {
            code: "VOFD1DB5A.1F6QU", format: "code_93"
        }, {
            code: "4SO64P4X8 U4YUU1T-", format: "code_93"
        }],
        filter: function(codeResult) {
            // only store results which match this constraint
            // e.g.: codeResult
            return true;
        }
    });
    var App = {
        init: function() {
            var self = this;

            Quagga.init(this.state, function(err) {
                if (err) {
                    return self.handleError(err);
                }
                //Quagga.registerResultCollector(resultCollector);
                App.attachListeners();
                App.checkCapabilities();
                Quagga.start();
            });
        },
        handleError: function(err) {
            console.log(err);
        },
        checkCapabilities: function() {
            var track = Quagga.CameraAccess.getActiveTrack();
            var capabilities = {};
            if (typeof track.getCapabilities === 'function') {
                capabilities = track.getCapabilities();
            }
            this.applySettingsVisibility('zoom', capabilities.zoom);
            this.applySettingsVisibility('torch', capabilities.torch);
        },
        updateOptionsForMediaRange: function(node, range) {
            console.log('updateOptionsForMediaRange', node, range);
            var NUM_STEPS = 6;
            var stepSize = (range.max - range.min) / NUM_STEPS;
            var option;
            var value;
            while (node.firstChild) {
                node.removeChild(node.firstChild);
            }
            for (var i = 0; i <= NUM_STEPS; i++) {
                value = range.min + (stepSize * i);
                option = document.createElement('option');
                option.value = value;
                option.innerHTML = value;
                node.appendChild(option);
            }
        },
        applySettingsVisibility: function(setting, capability) {
            // depending on type of capability
            if (typeof capability === 'boolean') {
                var node = document.querySelector('input[name="settings_' + setting + '"]');
                if (node) {
                    node.parentNode.style.display = capability ? 'block' : 'none';
                }
                return;
            }
            if (window.MediaSettingsRange && capability instanceof window.MediaSettingsRange) {
                var node = document.querySelector('select[name="settings_' + setting + '"]');
                if (node) {
                    this.updateOptionsForMediaRange(node, capability);
                    node.parentNode.style.display = 'block';
                }
                return;
            }
        },
        initCameraSelection: function(){
            var streamLabel = Quagga.CameraAccess.getActiveStreamLabel();

            return Quagga.CameraAccess.enumerateVideoDevices()
            .then(function(devices) {
                function pruneText(text) {
                    return text.length > 30 ? text.substr(0, 30) : text;
                }
                var $deviceSelection = document.getElementById("deviceSelection");
                while ($deviceSelection.firstChild) {
                    $deviceSelection.removeChild($deviceSelection.firstChild);
                }
                devices.forEach(function(device) {
                    var $option = document.createElement("option");
                    $option.value = device.deviceId || device.id;
                    $option.appendChild(document.createTextNode(pruneText(device.label || device.deviceId || device.id)));
                    $option.selected = streamLabel === device.label;
                    $deviceSelection.appendChild($option);
                });
            });
        },
        attachListeners: function() {
            var self = this;

            self.initCameraSelection();
            $(".controls").on("click", "button.stop", function(e) {
                e.preventDefault();
                Quagga.stop();
                self._printCollectedResults();
            });

            $(".controls .reader-config-group").on("change", "input, select", function(e) {
                e.preventDefault();
                var $target = $(e.target),
                    value = $target.attr("type") === "checkbox" ? $target.prop("checked") : $target.val(),
                    name = $target.attr("name"),
                    state = self._convertNameToState(name);

                console.log("Value of "+ state + " changed to " + value);
                self.setState(state, value);
            });
        },
        _printCollectedResults: function() {
            var results = resultCollector.getResults(),
                $ul = $("#result_strip ul.collector");

            results.forEach(function(result) {
                var $li = $('<li><div class="thumbnail"><div class="imgWrapper"><img /></div><div class="caption"><h4 class="code"></h4></div></div></li>');

                $li.find("img").attr("src", result.frame);
                $li.find("h4.code").html(result.codeResult.code + " (" + result.codeResult.format + ")");
                $ul.prepend($li);
            });
        },
        _accessByPath: function(obj, path, val) {
            var parts = path.split('.'),
                depth = parts.length,
                setter = (typeof val !== "undefined") ? true : false;

            return parts.reduce(function(o, key, i) {
                if (setter && (i + 1) === depth) {
                    if (typeof o[key] === "object" && typeof val === "object") {
                        Object.assign(o[key], val);
                    } else {
                        o[key] = val;
                    }
                }
                return key in o ? o[key] : {};
            }, obj);
        },
        _convertNameToState: function(name) {
            return name.replace("_", ".").split("-").reduce(function(result, value) {
                return result + value.charAt(0).toUpperCase() + value.substring(1);
            });
        },
        detachListeners: function() {
            $(".controls").off("click", "button.stop");
            $(".controls .reader-config-group").off("change", "input, select");
        },
        applySetting: function(setting, value) {
            var track = Quagga.CameraAccess.getActiveTrack();
            if (track && typeof track.getCapabilities === 'function') {
                switch (setting) {
                case 'zoom':
                    return track.applyConstraints({advanced: [{zoom: parseFloat(value)}]});
                case 'torch':
                    return track.applyConstraints({advanced: [{torch: !!value}]});
                }
            }
        },
        setState: function(path, value) {
            var self = this;

            if (typeof self._accessByPath(self.inputMapper, path) === "function") {
                value = self._accessByPath(self.inputMapper, path)(value);
            }

            if (path.startsWith('settings.')) {
                var setting = path.substring(9);
                return self.applySetting(setting, value);
            }
            self._accessByPath(self.state, path, value);

            console.log(JSON.stringify(self.state));
            App.detachListeners();
            Quagga.stop();
            App.init();
        },
        inputMapper: {
            inputStream: {
                constraints: function(value){
                    if (/^(\d+)x(\d+)$/.test(value)) {
                        var values = value.split('x');
                        return {
                            width: {min: parseInt(values[0])},
                            height: {min: parseInt(values[1])}
                        };
                    }
                    return {
                        deviceId: value
                    };
                }
            },
            numOfWorkers: function(value) {
                return parseInt(value);
            },
            decoder: {
                readers: function(value) {
                    if (value === 'ean_extended') {
                        return [{
                            format: "ean_reader",
                            config: {
                                supplements: [
                                    'ean_5_reader', 'ean_2_reader', 'ean_128_reader'
                                ]
                            }
                        }];
                    }
                    return [{
                        format: value + "_reader",
                        config: {}
                    }];
                }
            }
        },
        state: {
            inputStream: {
                type : "LiveStream",
                constraints: {
                    width: {min: 1280},
                    height: {min: 720},
                    facingMode: "environment",
                    aspectRatio: {min: 1, max: 2}
                }
            },
            locator: {
                patchSize: "medium",
                halfSample: true
            },
            numOfWorkers: 2,
            frequency: 10,
            decoder: {
                readers : [{
                    format: "ean_reader",
                    config: {}
                }]
            },
            locate: true
        },
        lastResult : null
    };

    App.init();

    Quagga.onProcessed(function(result) {
        var drawingCtx = Quagga.canvas.ctx.overlay,
            drawingCanvas = Quagga.canvas.dom.overlay;

        if (result) {
            if (result.boxes) {
                drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                result.boxes.filter(function (box) {
                    return box !== result.box;
                }).forEach(function (box) {
                    Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
                });
            }

            if (result.box) {
                Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
            }

            if (result.codeResult && result.codeResult.code) {
                Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
            }
        }
    });

    Quagga.onDetected(function(result) {
        var code = result.codeResult.code;

        if (App.lastResult !== code) {
            App.lastResult = code;
            var $node = null, canvas = Quagga.canvas.dom.image;

            $node = $('<li><div class="thumbnail"><div class="imgWrapper"><img /></div><div class="caption"><h4 class="code"></h4></div></div></li>');
            $node.find("img").attr("src", canvas.toDataURL());
            $node.find("h4.code").html(code);
            $("#result_strip ul.thumbnails").prepend($node);
            $('#txt-code').val(code);
           // document.getElementById('code_selected').value = 'hola2';
            console.log(code)
        }
    });

});

</script>