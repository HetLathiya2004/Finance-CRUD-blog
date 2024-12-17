<?php
session_start();
include 'partials\header.php';  

//fetch ategories from db
$query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $query);

?>


<section class="dashboard">
    <div class="container dashboard_container">
        <aside>
            <ul>
                <li><a href="add-post.php">Add Post</a></li>
                <li><a href="index.php">Manage Post</a></li>
                <?php if(isset($_SESSION['user-is-admin'])): ?>
                <li><a href="add-user.php">Add User</a></li>
                <li><a href="manage-users.php">Manage User</a></li>
                <li><a href="add-category.php">Add Category</a></li>
                <li><a href="manage-categories.php" class="active">Manage Category</a></li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage Categories</h2>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                    <tr>
                    <td><?= "{$category['title']}" ?></td>
                        <td><a href="<?= ROOT_URL ?>admin\edit-category.php?id=<?= $category['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin\delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger">Delete</a></td>
                       
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