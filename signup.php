<?php 
require 'config\constants.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance and Consulting Club</title>

    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    
<section class="form_section">
    <div class="container form_section_container">
        <h2>Sign Up</h2>
<?php
if (isset($_SESSION['signup'])): ?> 
    <div class="alert_message error">
        <p>
            <?= $_SESSION['signup'];
               unset($_SESSION['signup']);        
            ?>
        </p>
        
    </div>
<?php endif ?>
        <form action="<?= ROOT_URL ?>signup-logic.php" enctype="multipart/form-data" method="post">
            <input type="text" name="firstname" placeholder="First Name">
            <input type="text" name="lastname" placeholder="Last Name">
            <input type="text" name="username" placeholder="Username">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="createpassword" placeholder="Password">
            <input type="password" name="confirmpassword" placeholder="Confirm Password">
        
        <div class="form_control">
            <label for="avatar"></label>
            <input type="file" name="avatar" id="avatar">
        </div>
        
        <button type="submit" name="submit"  class="btn">Sign Up</button>
        <small>Already have an account? <a href="signin.php">Sign In</a></small>
    </form>
    </div>
</section>
</body>