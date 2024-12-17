<?php
session_start();
require 'config/database.php';

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    $is_featured = $is_featured == 1 ?: 0;

    //validate the form 
    if(!$title){
        $_SESSION['add-post'] = "Enter post title";
    }elseif (!$category_id) {
        $_SESSION['add-post'] = "Enter post category";
    }elseif (!$body) {
        $_SESSION['add-post'] = "Enter post body";
    }elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Post a Thumbnail";
    }else {
        $time = time();
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name']; // Fix the typo here
        $thumbnail_destination_path = '../images/' . DIRECTORY_SEPARATOR . $thumbnail_name;
        
        // make sure file is an image
        $allowed_files = ['png', 'jpg', 'jpeg'];
        $extension = pathinfo($thumbnail_name, PATHINFO_EXTENSION);
        
        if (in_array($extension, $allowed_files)) {
            // make sure img is not too large
            if ($thumbnail['size'] < 2000000) {
                // upload avatar
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = 'File size should be less than 1mb';
            }
        } else {
            $_SESSION['add-post'] = "File should be png, jpg, jpeg";
        }
    }
    
    //REDIRECT BACK TO ADD POST IF THERE IS PROBLEM
    if(isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin\add-post.php');
        die();
    }else {
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured=0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);

        }

        $query = "INSERT INTO posts SET title='$title', body='$body', thumbnail='$thumbnail_name', category_id='$category_id', author_id='$author_id', is_featured='$is_featured'";
        $result = mysqli_query($connection, $query);
        


        if (!mysqli_errno($connection)) {
            $_SESSION['add-post-sucess'] = "New Post added successfully";
            header('location: ' . ROOT_URL . 'admin\index.php');
            die();
        }
    }

}else{
header('location: ' . ROOT_URL . 'admin\add-post.php');
die();
}