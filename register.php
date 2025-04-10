<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = $_POST['cpass'];
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
   $select_user->execute([$email, $number]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'Email or number already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'Confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users` (name, email, number, password) VALUES (?, ?, ?, ?)");
         $insert_user->execute([$name, $email, $number, $pass]);

         $_SESSION['user_id'] = $conn->lastInsertId();
         header('location: home.php');
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="form-container">
<form action="" method="post" style="max-width: 350px; margin: 0 auto; border: 2px solid #333; padding: 20px; text-align: center; background-color: #f5f5f5; border-radius: 5px;">
    <h3 style="font-size: 24px; margin-bottom: 20px; color: #333;">Register Now</h3>
    <input type="text" name="name" required placeholder="Enter your name" class="box" maxlength="50" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; color: #333;">
    <input type="email" name="email" required placeholder="Enter your email" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; color: #333;">
    <input type="number" name="number" required placeholder="Enter your number" class="box" min="0" max="9999999999" maxlength="10" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; color: #333;">
    <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; color: #333;">
    <input type="password" name="cpass" required placeholder="Confirm your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')" style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; color: #333;">
    <input type="submit" value="Register Now" name="submit" class="btn" style="width: 100%; padding: 10px; margin: 10px 0; background-color: #333; color: #fff; border: none; border-radius: 5px; font-size: 18px; cursor: pointer;">
    <p style="font-size: 16px; margin-top: 10px; color: #333;">Already have an account? <a href="login.php" style="text-decoration: none; color: #333;">Login Now</a></p>
</form>

</section>











<?php include 'components/footer.php'; ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>