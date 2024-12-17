<?php
include 'partials\header.php'; 

// fetch users from db
$current_admin_id = $_SESSION['user-id'];
$query = "SELECT * FROM users WHERE NOT id = $current_admin_id";
$users = mysqli_query($connection, $query);




?>



<section class="dashboard">

    <?php if(isset($_SESSION['add-user-success'])) : ?>
    <div class="alert_message success container">
            <p>
                <?=
                $_SESSION['add-user-success'];
                unset($_SESSION['add-user-success']);
                ?>
            </p>
    </div>
    <?php elseif (isset($_SESSION['edit-user-success'])) : ?>
    <div class="alert_message success container">
            <p>
                <?=
                $_SESSION['edit-user-success'];
                unset($_SESSION['edit-user-success']);
                ?>
            </p>
    </div>
    <?php endif ?>

    <div class="container dashboard_container">

 

        <aside>
            <ul>
                <li><a href="add-post.php">Add Post</a></li>
                <li><a href="index.php">Manage Post</a></li>
                <?php if(isset($_SESSION['user-is-admin'])): ?>
                <li><a href="add-user.php">Add User</a></li>
                <li><a href="manage-users.php" class="active">Manage User</a></li>
                <li><a href="add-category.php">Add Category</a></li>
                <li><a href="manage-categories.php" >Manage Category</a></li>
                <?php endif ?>
            </ul>
        </aside>
        <main>
            <h2>Manage users</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Admin</th>
                    </tr>
                </thead>
                <tbody>

                <?php while($user = mysqli_fetch_assoc($users)) : ?>
                    <tr>
                    <td><?= "{$user['firstname']}  {$user['lastname']}" ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><a href="<?= ROOT_URL ?>admin\edit-user.php?id=<?= $user['id'] ?>" class="btn sm">Edit</a></td>
                        <td><a href="<?= ROOT_URL ?>admin\delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger">Delete</a></td>
                        <td><?= $user['is_admin'] ? "Yes" : "No" ?></td>
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