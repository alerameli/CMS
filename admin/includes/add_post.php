<?php
if (isset($_POST['create_post'])) {
    $post_title = $_POST['title'];
    $post_user = $_POST['post_user'];
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date('d-m-y');
    $post_comment_count = 0;
    move_uploaded_file($post_image_temp, "../imagenes/$post_image");

    $post_content=mysqli_real_escape_string($connection,$post_content);

    $query = "INSERT INTO posts(post_category,post_title,post_user,
    post_date,post_image,post_content,
    post_tags,post_comments,post_status) 
    VALUES ({$post_category_id},'{$post_title}','{$post_user}',
    now(),'{$post_image}','{$post_content}',
    '{$post_tags}','{$post_comment_count}','{$post_status}')";

    $create_post_query = mysqli_query($connection, $query);
    confirm($create_post_query);
    $the_post_id=mysqli_insert_id($connection);

    echo "<p class='bg-success'>Post created. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or 
    <a href='posts.php'>View other posts</a> </p>";
}
?>

<form action="" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="post_Category">Category</label>
        <select name="post_category_id" id="post_category">
            <option>--------</option>
            <?php
            $query = "SELECT * FROM categorias";
            $select_categories = mysqli_query($connection, $query);

            confirm($select_categories);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_title = $row['cat_titulo'];
                $cat_id = $row['cat_id'];
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }

            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_user">User</label>
        <select name="post_user" id="post_user">
            <option>--------</option>
            <?php
            $users_query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $users_query);

            confirm($select_users);
            while ($row = mysqli_fetch_assoc($select_users)) {
                $username = $row['user_username'];
                $user_id = $row['user_id'];
                echo "<option value='{$user_id}'>{$username}</option>";
            }

            ?>

        </select>
    </div>

    <div class="form-group">
        <select name="post_status" id="">
            <option value="draft">draft</option>
            <option value="published">published</option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea id="summernote" class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>



</form>