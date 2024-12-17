<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // fetch category  from db
    $query = "SELECT * FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);

    //UPDATE CATEGORY ID TO UNCATEGORISED
    $update_query = "UPDATE posts SET category_id=3 WHERE category_id=$id";
    $update_result = mysqli_query($connection, $update_query);

    if (!mysqli_errno($connection)) {
        $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);

        $_SESSION['delete-category-success'] = "Category deleted successfully";
    }

    //DELETE category FROM DB
    $delete_user_query = "DELETE FROM categories WHERE id=$id";
    $delete_user_result = mysqli_query($connection, $delete_user_query);
    if (mysqli_errno($connection)) {
        $_SESSION['delete-category'] = "THERE WAS AN ERROR";
    } else {
        $_SESSION['delete-category-success'] = "User Deleted Sucessfully";
    }
}

header('location: ' . ROOT_URL . 'admin\manage-categories.php');
die();