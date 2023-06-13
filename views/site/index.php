<?php
use yii\bootstrap5\Html;

/** @var yii\web\View $this */


$this->title = 'My Yii Application';
   if(isset($libros_Array)){
      
      $novedadesArray = array_filter($libros_Array, function($item) {
         return $item['novedades'] === 'S';
     });
    
   }
 
?>
<style>

.search-txt i{
    font-size: 40px;
    color: #f8010a
}

.search-txt h2{
    color: #111111;
    font-size: 30px;
    margin-left: 10px;
}

.movies{
    padding: 50px 0 150px 0;
}

.movies h2{
    font-size: 25px;
    font-weight: 400;
    margin-bottom: 20px;
}

.swiper{
    width: 100%;
}

.swiper-slide{
    background-position: center;
    background-size: cover;
    width: 250px;
    height: auto;
}



.swiper-slide img{
    display: block;
    object-fit: cover;
    width: 100%;
    height: 100%;
}

.conteiner-img{
   height: 100%;
}





@media(max-width:991px){
    body{
        min-height: 0vh;
    }
    .search{
        padding: 30px 30px 0 30px
    }

    .movies{
        padding: 30px;
    }

    
}


</style>

<section class="movies container">
        <h2>Novedades</h2>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                            
            </div>
        </div>

    </section>

<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
   // Pasar el array novedadesArray de PHP a JavaScript
   var novedadesArray = <?php echo json_encode($novedadesArray); ?>;
   console.log(novedadesArray);
   var novedadesArrayValues = Object.values(novedadesArray);
   console.log(novedadesArrayValues);
   // Utilizar el array en tu código JavaScript
   const swiperWrapper = document.querySelector('.swiper-wrapper');

   novedadesArrayValues.forEach(item => {
  const anchor = document.createElement('a');
  anchor.classList.add('swiper-slide');
  anchor.href = '<?= Yii::$app->urlManager->createUrl(["libro/view", "id2" => ""]) ?>'+item.id;

  const containerImg = document.createElement('div');
  containerImg.classList.add('conteiner-img');

  const image = document.createElement('img');
  image.src = item.lib_imagen;
  image.alt = '';

  containerImg.appendChild(image);
  anchor.appendChild(containerImg);
  swiperWrapper.appendChild(anchor);
});
novedadesArrayValues.forEach(item => {
  const anchor = document.createElement('a');
  anchor.classList.add('swiper-slide');
  anchor.href = '<?= Yii::$app->urlManager->createUrl(["libro/view", "id2" => ""]) ?>'+item.id;

  const containerImg = document.createElement('div');
  containerImg.classList.add('conteiner-img');

  const image = document.createElement('img');
  image.src = item.imagen;
  image.alt = '';

  containerImg.appendChild(image);
  anchor.appendChild(containerImg);
  swiperWrapper.appendChild(anchor);
});
</script>

<script>

   var swiper = new Swiper(".mySwiper",{
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      coverFlowEffect:{
         rotate:15,
         strech:0,
         depth: 300,
         modifier: 1,
         slideShadows: true,
      },
      loop:true,
   });

</script>



