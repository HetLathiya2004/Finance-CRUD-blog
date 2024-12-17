<?php
include 'partials\header.php';  

//fetch categories from db
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

//fetch post data fromthe id
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
}else {
    header('location: ' . ROOT_URL . 'admin\index.php');
}
?>


<section class="form_section">
    <div class="container form_section_container">
        <h2>Edit Post</h2>
        <?php if (isset($_SESSION['edit-post'])): ?> 
            <div class="alert_message error">
               <p>
                    <?= $_SESSION['edit-post'];
                    unset($_SESSION['edit-post']);        
                    ?>
               </p>
        
            </div>
        <?php endif ?>

        <form action="<?= ROOT_URL ?>admin\edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= $post['thumbnail'] ?>">
            <input type="text" name="title" placeholder="Title">
            <select name="category">
                <?php while($category = mysqli_fetch_assoc($categories)) : ?>
                <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endwhile ?>
            </select>

            <textarea rows="10" name="body" placeholder="Body"></textarea>

            <?php if(isset($_SESSION['user-is-admin'])) : ?>
            <div class="form_control inline">
            <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <?php endif ?>

            <div class="form_control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>

        <button type="submit" name="submit" class="btn">Update Post</button>
    </form>
    </div>
</section>






<?php
include '..\partials\footer.php';
?>