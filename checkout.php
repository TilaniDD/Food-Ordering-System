<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'please add your address!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'order placed successfully!';
      }
      
   }else{
      $message[] = 'your cart is empty';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

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
   <h3>checkout</h3>
   <p><a href="home.php">home</a> <span> / checkout</span></p>
</div>

<section class="checkout">

   <h1 class="title">order summary</h1>

   <form action="" method="post" style="max-width: 600px; margin: 0 auto; text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 5px; border: 2px solid #333;">
    <div class="cart-items" style="background-color: #fff; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
        <h3 style="font-size: 24px; color: #333;">Cart Items</h3>
        <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                    $total_products = implode($cart_items);
                    $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
        ?>
        <p><span class="name" style="font-weight: bold;"><?= $fetch_cart['name']; ?></span><span class="price">Rs.<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
        <?php
                }
            } else {
                echo '<p class="empty" style="color: #555;">Your cart is empty!</p>';
            }
        ?>
        <p class="grand-total" style="font-weight: bold;"><span class="name">Grand Total :</span><span class="price">Rs.<?= $grand_total; ?></span></p>
        <a href="cart.php" class="btn" style="background-color: #333; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px; margin-top: 10px; display: inline-block;">View Cart</a>
    </div>

    <input type="hidden" name="total_products" value="<?= $total_products; ?>">
    <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
    <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
    <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
    <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
    <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

    <div class="user-info" style="background-color: #fff; padding: 20px; border-radius: 5px;">
        <h3 style="font-size: 24px; color: #333;">Your Info</h3>
        <p><i class="fas fa-user" style="color: #333;"></i><span style="color: #333;"><?= $fetch_profile['name'] ?></span></p>
        <p><i class="fas fa-phone" style="color: #333;"></i><span style="color: #333;"><?= $fetch_profile['number'] ?></span></p>
        <p><i class="fas fa-envelope" style="color: #333;"></i><span style="color: #333;"><?= $fetch_profile['email'] ?></span></p>
        <a href="update_profile.php" class="btn" style="background-color: #333; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px; display: inline-block; margin-top: 10px;">Update Info</a>

        <h3 style="font-size: 24px; color: #333; margin-top: 20px;">Delivery Address</h3>
        <p><i class="fas fa-map-marker-alt" style="color: #333;"></i><span style="color: #333;"><?php if($fetch_profile['address'] == ''){echo 'Please enter your address';}else{echo $fetch_profile['address'];} ?></span></p>
        <a href="update_address.php" class="btn" style="background-color: #333; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px; display: inline-block; margin-top: 10px;">Update Address</a>

        <select name="method" class="box" required style="width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; color: #333;">
            <option value="" disabled selected>Select Payment Method --</option>
            <option value="cash on delivery">Cash on Delivery</option>
            <option value="credit card">Credit Card</option>
            <option value="paytm">Paytm</option>
            <option value="paypal">Paypal</option>
        </select>
        <input type="submit" value="Place Order" class="btn" style="width: 100%; padding: 10px; background: var(--red); color: var(--white); border: none; border-radius: 5px; font-size: 18px; cursor: pointer; margin-top: 10px;" name="submit" <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>>
    </div>
</form>

   
</section>









<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>