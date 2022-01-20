<?php

if (isset($_GET['u_id'])) {
    $the_user_id = $_GET['u_id'];
}
$query = "SELECT * FROM users WHERE user_id={$the_user_id}";
$select_user_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_user_by_id)) {
    $user_id = $row['user_id'];
    $user_username = $row['user_username'];
    $user_password = $row['user_password'];
    $user_first_name = $row['user_first_name'];
    $user_last_name = $row['user_last_name'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
    $user_role = $row['user_role'];
}

if (isset($_POST['edit_user'])) {
    $user_username = $_POST['user_username'];
    $user_password = $_POST['user_password'];
    $user_first_name = $_POST['user_first_name'];
    $user_last_name = $_POST['user_last_name'];
    $user_email = $_POST['user_email'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_temp = $_FILES['user_image']['tmp_name'];
    $user_role = $_POST['user_role'];
    move_uploaded_file($user_image_temp, "../imagenes/$user_image");

    if (empty($user_image)) {
        $query = "SELECT * FROM users WHERE user_id=$the_user_id";
        $select_image = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($select_image)) {
            $user_image = $row['user_image'];
        }
    }

    if (!empty($user_password)) {
        $query_password = "SELECT user_password FROM users WHERE user_id=$the_user_id";
        $get_user = mysqli_query($connection, $query);
        confirm($get_user);

        $row = mysqli_fetch_array($get_user);
        $db_user_password = $row['user_password'];

        if ($db_user_password != $user_password) {
            $hash_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
        }

        $query = "UPDATE users SET
            user_username='{$user_username}',
            user_password='{$hash_password}',
            user_first_name='{$user_first_name}',
            user_last_name='$user_last_name',
            user_email='{$user_email}',
            user_image='{$user_image}', 
            user_role='{$user_role}' 
            WHERE user_id={$the_user_id}";

        $update_user = mysqli_query($connection, $query);
        confirm($update_user);

        echo "User Updated "."<a href='users.php'>View users</a>";
    }
}
?>

<form action="" method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_name">Username</label>
        <input type="text" class="form-control" name="user_username" value="<?php echo $user_username; ?>">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <label for="user_emali">Firstname</label>
        <input type="text" class="form-control" name="user_first_name" value="<?php echo $user_first_name; ?>">
    </div>
    <div class="form-group">
        <label for="post_image">Lastname</label>
        <input type="text" class="form-control" name="user_last_name" value="<?php echo $user_last_name; ?>">
    </div>

    <div class="form-group">
        <label for="post_tags">Email</label>
        <input type="text" class="form-control" name="user_email" value="<?php echo $user_email; ?>">
    </div>

    <div class="form-group">
        <label for="user_image">Image</label>
        <img width="100" src="../imagenes/<?php echo $user_image; ?>" alt="">
        <input type="file" name="user_image">
    </div>
    <div class="form-group">
        <label for="user_role">Role</label>
        <select name="user_role" id="user_role">
            <option <?php if ($user_role == 'Admin') {
                        echo 'selected';
                    } ?> value='Admin'>Admin</option>;
            <option <?php if ($user_role == 'Subscriber') {
                        echo 'selected';
                    } ?> value='Subscriber'>Subscriber</option>


        </select>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>



</form>