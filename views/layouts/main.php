<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use app\assets\AppAsset;


?>
 
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<script src="https://kit.fontawesome.com/663d89665d.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header id="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="<?= Url::toRoute(['site/index']); ?>">Inicio</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent #navEnd" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= Url::toRoute(['libro/index']); ?>">Libros</a>
                        
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="<?= Url::toRoute(['reserva/index']); ?>">Reservas</a>

                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['reserva/index']); ?>">Reservas</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['libro/sugerencias']); ?>">Sugerencias</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['libro/favoritos']); ?>">Favoritos</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['usuario/comentarios']); ?>">Comentarios</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['categoria/index']); ?>">Categorias</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= Url::toRoute(['subcategoria/index']); ?>">Sub categorias</a>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto">
                       
                       <?php if (Yii::$app->user->isGuest) { ?>
                          <li class="nav-item active">
                              <a class="nav-link" href="<?= Url::toRoute(['site/login']); ?>">Login</a>
                          </li>
                      <?php } else { ?>
                          <li class="nav-item active">
                              <form action="<?= Url::toRoute(['site/logout']); ?>" method="post">
                              <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                                  <?= Html::submitButton(
                                      'Logout (' . Yii::$app->user->identity->id . ')'."  Tipo:".Yii::$app->session['tipo_usuario'],
                                      ['class' => 'nav-link btn btn-link logout']
                                  ); ?>
                              </form>
                          </li>
                      <?php } ?>
                         
                      </ul>
            </div>
            
        </nav>
    </header>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>
    <footer id="footer" class="mt-auto py-3 bg-light">
        <div class="container">
            <div class="row text-muted">
                <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
                <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>