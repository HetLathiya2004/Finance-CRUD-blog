<?php
require 'config\databse.php';

if (isset($_POST['submit'])) {
    //get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password  = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['signin'] = "Username or Email required";

    }elseif (!$password) {
        $_SESSION['signin'] = "Paswword Required";
    }else {
        //fetch user from db
        $fetch_user_query = "SELECT * FROM users WHERE username = '$username_email' OR email='$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            //convert record into associative array

            $user_record = mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];

            // compare the password with db password
            if (password_verify($password, $db_password)) {
                //sert session for access control
                $_SESSION['user-id'] = $user_record['id'];
                //check if user is admin or not

                if ($user_record['is_admin'] == 1) {
                    $_SESSION['user-is-admin'] = true;
                }
                header('location: ' . ROOT_URL . 'admin\index.php');

            }else{
                $_SESSION['signin'] = 'Please Check Your input';
            }
        }
        else {
            $_SESSION['signin'] = "User Not Found";
        }
    }

    //if any problemredirect to signin page
if(isset($_SESSION['signin'])){
    $_SESSION['sigin-data'] = $_POST;
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
   
}



 else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}
