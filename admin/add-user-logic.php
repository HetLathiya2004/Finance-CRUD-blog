<?php

require 'config/database.php';

//getting suser form data when button clicked
if (isset($_POST['submit'])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // validation

    if (!$firstname) {
        $_SESSION['add-user'] = "Enter Your First Name";
    }
     elseif (!$lastname) {
        $_SESSION['add-user'] = "Enter Your Last Name";
    }
     elseif (!$username) {
        $_SESSION['add-user'] = "Enter Your UserName";
    } 
    elseif (!$email) {
        $_SESSION['add-user'] = "Enter Your Email";
    }
    elseif (strlen($createpassword < 8 || strlen($confirmpassword < 8))) {
        $_SESSION['add-user'] = "Password should be more than 8 characters";
    }
     elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Add avatar";
    }
    else {
        //check if passwords match or not
        if ($createpassword !== $confirmpassword) {
          $_SESSION['add-user'] = "Passwords do not match";
        }else {
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            //check if username or email already exists
            $user_check_query = "SELECT * FROM  users WHERE username =  '$username' OR email = '$email'"; 
            $user_check_result = mysqli_query($connection, $user_check_query);

            if (mysqli_num_rows($user_check_result) > 0) {
                $_SESSION['add-user'] = "Username  or email already exists";
            }else{
                // WRORK on AVATAR

// WRORK on AVATAR
$time = time();
$avatar_name = $time . $avatar['name'];
$avatar_tmp_name = $avatar['tmp_name']; // Fix the typo here
$avatar_destination_path = '../images/' . DIRECTORY_SEPARATOR . $avatar_name;

// make sure file is an image
$allowed_files = ['png', 'jpg', 'jpeg'];
$extension = pathinfo($avatar_name, PATHINFO_EXTENSION);

if (in_array($extension, $allowed_files)) {
    // make sure img is not too large
    if ($avatar['size'] < 1000000) {
        // upload avatar
        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
    } else {
        $_SESSION['add-user'] = 'File size should be less than 1mb';
    }
} else {
    $_SESSION['add-user'] = "File should be png, jpg, jpeg";
}


            }
        }
    }
// redirect to add-user if there  is a problem
    if (isset($_SESSION['add-user'])) {
        header('location: ' .ROOT_URL . 'admin\add-user.php');
        die();
    
    }else {
        //insert new user to the table/ databaase
    
        $insett_user_query = "INSERT INTO users SET firstname='$firstname', lastname='$lastname', username='$username', email='$email', password='$hashed_password', avatar='$avatar_name', is_admin = $is_admin" ;
        $insert_user_result = mysqli_query($connection, $insett_user_query);
    }

    if (!mysqli_error($connection)) {
        $_SESSION['add-user-success'] = "New User $firstname $lastname added successfully";
        header('location: ' . ROOT_URL . 'admin\manage-users.php');
        die();
    }

}



else{
    //if btn wasnt clicked then get back to add-user pag
    header('location: ' . ROOT_URL . 'admin\add-user.php');
    die();
}
                             