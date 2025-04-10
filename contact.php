<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

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
   <h3>contact us</h3>
   <p><a href="home.php">home</a> <span> / contact</span></p>
</div>

<!-- contact section starts  -->

<section class="contact" style="background-color: #f2f2f2; padding: 20px; text-align: center;">

   <div class="row" style="display: flex; justify-content: center; align-items: center;">

      <div class="image" style="flex: 1;">
         <img src="images/contact-img.svg" alt="" style="max-width: 100%; height: auto;">
      </div>
      <section class="contact" style="background-color: #f2f2f2; padding: 20px; text-align: center;">

<div class="row" style="display: flex; justify-content: center; align-items: center;">

   <div class="image" style="flex: 1;">
      <img src="images/contact-img.svg" alt="" style="max-width: 100%; height: auto;">
   </div>

   <form action="" method="post" style="flex: 1; background-color: #fff; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); text-align: center;">

      <h3 style="font-size: 24px; margin-bottom: 20px; color: #333;">tell us something!</h3>

      <input type="text" name="name" maxlength="50" class="box" placeholder="enter your name" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
      <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="enter your number" required maxlength="10" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
      <input type="email" name="email" maxlength="50" class="box" placeholder="enter your email" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
      <textarea name="msg" class="box" required placeholder="enter your message" maxlength="500" cols="30" rows="10" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;"></textarea>
      <input type="submit" value="send message" name="send" class="btn" style="background-color: #333; color: #fff; padding: 10px 20px; text-decoration: none; border: none; border-radius: 5px; font-size: 18px; cursor: pointer;">
   </form>

</div>

</section>


<!-- contact section ends -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>