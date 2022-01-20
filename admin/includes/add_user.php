<?php
if (isset($_POST['create_user'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];
    $user_first_name = $_POST['user_first_name'];
    $user_last_name = $_POST['user_last_name'];
    $user_email = $_POST['user_email'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    $user_role = $_POST['user_role'];
    move_uploaded_file($user_image_temp, "../imagenes/$user_image");

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users(user_username,user_password,user_first_name,
    user_last_name,user_email,user_image,
    user_role) 
    VALUES ('{$user_username}','{$user_password}','{$user_first_name}',
    '{$user_last_name}','{$user_email}','{$user_image}',
    '{$user_role}')";

    $create_user_query = mysqli_query($connection, $query);
    confirm($create_user_query);

    echo "User Created: " . " " . "<a href='users.php'>View users</a>";
}
?>

<form action="" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" class="form-control" name="user_username">
    </div>

    <div class="form-group">
        <label for="author">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <label for="post_status">Firstname</label>
        <input type="text" class="form-control" name="user_first_name">
    </div>
    <div class="form-group">
        <label for="post_image">Lastname</label>
        <input type="text" class="form-control" name="user_last_name">
    </div>

    <div class="form-group">
        <label for="post_tags">Email</label>
        <input type="text" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="post_content">Image</label>
        <input type="file" name="user_image">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" class="form-control" id="">
            <option value="Subscriber">Selct option</option>
            <option value="Admin">Admin</option>
            <option value="Subscriber">Subscriber</option>
        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
    </div>



</form>