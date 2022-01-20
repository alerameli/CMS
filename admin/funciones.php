<?php

function escape($string)
{
    global $connection;
    mysqli_real_escape_string($connection, trim($string));
}


function checkStatus($table, $column_name, $status)
{
    global $connection;
    $query = "SELECT * FROM  $table WHERE $column_name  =  '$status'";
    $result = mysqli_query($connection, $query);
    confirm($result);
    return mysqli_num_rows($result);
}

function recordCount($table)
{
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select_all_post = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_all_post);
    confirm($result);
    return $result;
}

function insert_categories()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $stmt = mysqli_prepare($connection,"INSERT INTO categorias(cat_titulo) VALUES(?)");
            mysqli_stmt_bind_param($stmt,'s',$cat_title);
            mysqli_stmt_execute($stmt);
            if (!$stmt) {
                die("Query failed" . mysqli_error($connection));
            }
        }
    }
}

function findAllCategories()
{
    global $connection;
    $query = "SELECT * FROM categorias";
    $select_categories = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_title = $row['cat_titulo'];
        $cat_id = $row['cat_id'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>DELETE</a></td>";
        echo "<td><a href='categories.php?update={$cat_id}'>UPDATE</a></td>";
        echo "</tr>";
    }
}

function delete_categories()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM categorias
                WHERE cat_id={$the_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header("Location:categories.php");
    }
}

function confirm($result)
{
    global $connection;
    if (!$result) {
        die("Query failed " . mysqli_error($connection));
    }
}

function users_online()
{
    if (isset($_GET['onlineusers'])) {
        global $connection;

        if (!$connection) {
            session_start();
            include("../includes/db.php");
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session='$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session,time)VALUES('$session','$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time='$time' WHERE session='$session'");
            }
            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time >'$time_out'");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }
}

function is_admin($username)
{
    global $connection;
    $query = "SELECT user_role FROM users WHERE user_username='$username'";
    $result = mysqli_query($connection, $query);
    confirm($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_role'] == 'Admin') {
        return true;
    } else {
        return false;
    }
}


function username_exist($username)
{
    global $connection;
    $query = "SELECT user_username FROM users WHERE user_username='$username'";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
function email_exist($email)
{
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email='$email'";
    $result = mysqli_query($connection, $query);
    confirm($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function redirect($location)
{
    return header("Location:" . $location);
}

function register_user($username, $email, $password)
{
    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users(user_username,user_email,user_password,user_role)
                VALUES('{$username}','{$email}','$password','Subscriber')";
    $register_user_query = mysqli_query($connection, $query);
    confirm($register_user_query);
}

function login_user($username, $password)
{
    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE user_username='{$username}'";
    $select_user_query = mysqli_query($connection, $query);
    if (!$select_user_query) {
        die("Query failed: " . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_assoc($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_user_username = $row['user_username'];
        $db_user_first_name = $row['user_first_name'];
        $db_user_last_name = $row['user_last_name'];
        $db_user_role = $row['user_role'];
        $db_user_password = $row['user_password'];
    }

    if (password_verify($password, $db_user_password)) {
        $_SESSION['user_id'] = $db_user_id;
        $_SESSION['username'] = $db_user_username;
        $_SESSION['firstname'] = $db_user_first_name;
        $_SESSION['lastname'] = $db_user_last_name;
        $_SESSION['user_role'] = $db_user_role;
        redirect("/cms/admin");
    } else {
        redirect("/cms/index.php");
    }
}


users_online();
