<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th>Admin</th>
            <th>Subscriber</th>
            <th>Update</th>
            <th>Delete</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['user_id'];
            $user_username = $row['user_username'];
            $user_password = $row['user_password'];
            $user_first_name = $row['user_first_name'];
            $user_last_name = $row['user_last_name'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

            echo "<tr>";
            echo "<td>{$user_id}</td>";
            echo "<td>{$user_username}</td>";
            echo "<td>{$user_first_name}</td>";
            echo "<td>{$user_last_name}</td>";
            echo "<td>{$user_email}</td>";
            echo "<td>{$user_role}</td>";
            echo "<td><a href='users.php?Admin={$user_id}'> Admin</a></td> ";
            echo "<td><a href='users.php?Subscriber={$user_id}'> Subscriber</a></td> ";
            echo "<td><a href='users.php?source=edit_user&u_id={$user_id}'> Update</a></td> ";
            echo "<td><a href='users.php?delete={$user_id}'> Delete</a></td> ";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<?php

if (isset($_GET['Admin'])) {
    $the_user_id = $_GET['Admin'];
    $query = "UPDATE users SET user_role='Admin' 
                WHERE user_id=$the_user_id";
    $update_query = mysqli_query($connection, $query);
    confirm($update_query);
    header("Location:users.php");
}

if (isset($_GET['Subscriber'])) {
    $the_user_id = $_GET['Subscriber'];
    $query = "UPDATE users SET user_role='Subscriber' 
                WHERE user_id=$the_user_id";
    $update_query = mysqli_query($connection, $query);
    confirm($update_query);
    header("Location:users.php");
}

if (isset($_GET['delete'])) {
    if (isset($_SESSION['user_role'])) {

        if ($_SESSION['user_role'] == 'Admin') {
            $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
            $query = "DELETE FROM users WHERE user_id= {$the_user_id}";
            $delete_query = mysqli_query($connection, $query);
            confirm($delete_query);
            header("Location:users.php");
        }
    }
}
?>