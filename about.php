<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>





<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>about us</h3>
   <p><a href="home.php">home</a> <span> / about</span></p>
</div>

<!-- about section starts  -->

<section class="about">

   <div class="row">

      <div class="image">
         <img src="images/about.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>"Welcome to Signature Cuisine! At our restaurant, we take pride in offering a dining experience that goes beyond just food; it's about creating memorable moments and satisfying your culinary desires.</p>
         <a href="menu.html" class="btn">our menu</a>
      </div>

   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->

<section class="steps" style="background-color: #f8f8f8; padding: 30px 0; text-align: center;">

   <h1 class="title" style="font-size: 32px; color: #333;">Simple Steps</h1>

   <div class="box-container" style="display: flex; justify-content: center; align-items: center;">

      <div class="box" style="text-align: center; margin: 0 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
         <img src="images/step-1.png" alt="Step 1" style="max-width: 100%; height: auto;">
         <h3 style="font-size: 20px; color: #333;">Choose Order</h3>
      </div>

      <div class="box" style="text-align: center; margin: 0 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
         <img src="images/step-2.png" alt="Step 2" style="max-width: 100%; height: auto;">
         <h3 style="font-size: 20px; color: #333;">Fast Delivery</h3>
      </div>

      <div class="box" style="text-align: center; margin: 0 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
         <img src="images/step-3.png" alt="Step 3" style="max-width: 100%; height: auto;">
         <h3 style="font-size: 20px; color: #333;">Enjoy Food</h3>
      </div>

   </div>

</section>


<!-- steps section ends -->

<!-- reviews section starts  -->

<section class="reviews">



   <div class="swiper reviews-slider">

      
      <div class="swiper-pagination"></div>

   </div>

</section>

<!-- reviews section ends -->



















<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->=






<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   grabCursor: true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
      slidesPerView: 1,
      },
      700: {
      slidesPerView: 2,
      },
      1024: {
      slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>