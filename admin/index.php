<?php
session_start();
include 'partials\header.php';  

$current_user_id = $_SESSION['user-id'];
$query = "SELECT id,title,category_id FROM posts WHERE author_id = $current_user_id ORDER BY id DESC";
$posts = mysqli_query($connection, $query);

?>


<section class="dashboard">
    <div class="container dashboard_container">
        <aside>
            <ul>
                <li><a href="add-post.php">Add Post</a></li>
                <li><a href="index.php" class="active">Manage Post</a></li>
                <?php if (isset($_SESSION['user-is-admin'])): ?>
                <li><a href="add-user.php">Add User</a></li>
                <li><a href="manage-users.php">Manage User</a></li>
                <li><a href="add-category.php">Add Category</a></li>
                <li><a href="manage-categories.php" >Manage Category</a></li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Posts</h2>
            <table>          
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    
                <?php while($post = mysqli_fetch_assoc($posts)) : ?>
                    <!-- get category from dba -->
                    <?php 
                     $category_id = $post['category_id'];
                     $category_query = "SELECT title FROM categories WHERE id=$category_id";
                     $category_result = mysqli_query($connection, $category_query);
                     $category = mysqli_fetch_assoc($category_result);
                    ?>

                    <tr>
                        <td><?= "{$post['title']}" ?></td>
                        <td><?= "{$category['title']}" ?></td>
                        <td><a href="<?= ROOT_URL ?>admin\edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin\delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger">Delete</a></td>
                    </tr>
                <?php endwhile ?>



                </tbody>
            </table>
        </main>
    </div>
</section>


<?php
include '..\partials\footer.php';
?>