<?php

if (isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}
$query = "SELECT * FROM posts WHERE post_id={$the_post_id}";
$select_post_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_post_by_id)) {
    $post_id = $row['post_id'];
    $post_title = $row['post_title'];
    $post_user = $row['post_user'];
    $post_category = $row['post_category'];
    $post_Status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comments = $row['post_comments'];
    $post_date = $row['post_date'];
}

if (isset($_POST['update_post'])) {
    $post_title = $_POST['post_title'];
    $post_user = $_POST['post_user'];
    $post_category = $_POST['post_category'];
    $post_Status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];
    move_uploaded_file($post_image_temp, "../imagenes/$post_image");

    if (empty($post_image)) {
        $query = "SELECT * FROM posts WHERE post_id=$the_post_id";
        $select_image = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $post_content = mysqli_real_escape_string($connection, $post_content);

    $query = "UPDATE posts SET
            post_title='{$post_title}',
            post_category='{$post_category}',
            post_date=now(),
            post_user='$post_user',
            post_status='{$post_Status}',
            post_tags='{$post_tags}',
            post_content='{$post_content}',
            post_image='{$post_image}' 
            WHERE post_id={$the_post_id}";

    $update_post = mysqli_query($connection, $query);
    confirm($update_post);

    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or 
            <a href='posts.php'>View other posts</a> </p>";
}
?>

<form action="" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="post_category">Category</label>
        <select name="post_category" id="post_category">
            <?php
            $query = "SELECT * FROM categorias";
            $select_categories = mysqli_query($connection, $query);

            confirm($select_categories);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_title = $row['cat_titulo'];
                $cat_id = $row['cat_id'];
               

                if($cat_id==$post_category){
                    echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
                }else{
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }
            }
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_user">User</label>
        <select name="post_user" id="post_user">
            <?php
            $query = "SELECT user_username FROM users WHERE user_id=$post_user";
            $select_user = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($select_user)) {
                $post_user = $row['user_username'];
            }
            echo "<option value='{$user_id}'>{$post_user}</option>";
            ?>
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
        <label for="post_status">Status</label>
        <select name="post_status" id="">
            <option value="<?php echo $post_Status ?>">
                <?php echo $post_Status; ?>
            </option>
            <?php if ($post_Status == 'published') {
                echo "<option value='draft'>draft</option>'";
            } else {
                echo "<option value='published'>published</option>'";
            }
            ?>
        </select>
    </div>


    <div class="form-group">
        <img width="100" src="../imagenes/<?php echo $post_image; ?>" alt="">
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>



</form>