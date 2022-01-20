<?php include "includes/admin_header.php"; ?>

<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id={$user_id}";
    $select_user_profile = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($select_user_profile)) {
        $user_id = $row['user_id'];
        $user_username = $row['user_username'];
        $user_password = $row['user_password'];
        $user_first_name = $row['user_first_name'];
        $user_last_name = $row['user_last_name'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
}
?>


<?php 

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



    $query = "UPDATE users SET
            user_username='{$user_username}',
            user_password='{$user_password}',
            user_first_name='{$user_first_name}',
            user_last_name='$user_last_name',
            user_email='{$user_email}',
            user_image='{$user_image} '
            WHERE user_id={$user_id}";

    $update_user = mysqli_query($connection, $query);
    confirm($update_user);
}
?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin
                        <small>Author</small>
                    </h1>
                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="user_name">Username</label>
                            <input type="text" class="form-control" name="user_username" value="<?php echo $user_username; ?>">
                        </div>

                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
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
                            <input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
                        </div>



                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>