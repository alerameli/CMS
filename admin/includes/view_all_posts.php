<?php
include("delete_modal.php");
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueID) {

        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id='$postValueID'";
                $update_to_published_status = mysqli_query($connection, $query);
                confirm($update_to_published_status);
                break;
            case 'draft':
                $query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id='$postValueID'";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirm($update_to_draft_status);
                break;
            case 'delete':
                $query = "DELETE FROM posts WHERE post_id='$postValueID'";
                $delete_query = mysqli_query($connection, $query);
                confirm($delete_query);
                break;
            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id='{$postValueID}'";
                $select_post_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_category = $row['post_category'];
                    $post_Status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comments = $row['post_comments'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                }
                $query = "INSERT INTO posts(post_category,post_title,post_user,
                post_date,post_image,post_content,
                post_tags,post_status) 
                VALUES('{$post_category}','{$post_title}','{$post_user}',
                now(),'{$post_image}','{$post_content}',
                '{$post_tags}','{$post_Status}')";
                $copy_query = mysqli_query($connection, $query);
                if (!$copy_query) {
                    die("Query failed " . mysqli_error($connection));
                }
                break;
        }
    }
}


?>
<form action="" method="POST">
    <table class="table table-bordered table-hover">

        <div style="padding: 0px;" id="bulkOptionesContainer" class="col-xs-4">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select Option</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>

        </div>
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>
        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>ID</th>
                <th>Title</th>
                <th>User</th>

                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Views</th>
            </tr>
        </thead>
        <tbody>
            <?php
            //$query = "SELECT * FROM posts ORDER BY post_id DESC";
            $query = "SELECT posts.post_id, posts.post_user,posts.post_title,posts.post_category,posts.post_status,posts.post_image 
            ,posts.post_tags,posts.post_comments,posts.post_date,posts.post_views_count
            ,categorias.cat_id,categorias.cat_titulo FROM posts LEFT JOIN categorias ON posts.post_category=categorias.cat_id ";
            $select_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_category = $row['post_category'];
                $post_Status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comments = $row['post_comments'];
                $post_date = $row['post_date'];
                $post_views_count = $row['post_views_count'];
                $cat_title = $row['cat_titulo'];
                $cat_id = $row['cat_id'];

                echo "<tr>";
            ?>
                <td><input class="checkBoxes" type='checkbox' name='checkBoxArray[]' value="<?php echo $post_id; ?>"></td>
                <?php
                echo "<td>{$post_id}</td>";
                echo "<td>{$post_title}</td>";

                if (!empty($post_author)) {
                    echo "<td>{$post_author}</td>";
                } elseif (!empty($post_user)) {
                    $query = "SELECT user_username FROM users WHERE user_id=$post_user";
                    $select_user = mysqli_query($connection, $query);
                    while ($row = mysqli_fetch_array($select_user)) {
                        $post_user = $row['user_username'];
                    }
                    echo "<td>{$post_user}</td>";
                }



                echo "<td>{$cat_title}</td>";

                echo "<td>{$post_Status}</td>";
                echo "<td><img width=100 src='../imagenes/$post_image'></td>";
                echo "<td>{$post_tags}</td>";

                $query = "SELECT * FROM comments WHERE comment_post_id=$post_id";
                $send_comment_querry = mysqli_query($connection, $query);
                $count_comments = mysqli_num_rows($send_comment_querry);
                echo "<td> <a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";


                echo "<td>{$post_date}</td>";
                echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>VIEW POST</a></td> ";
                echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>UPDATE</a></td> ";

                ?>
                <form action="" method="POST">
                    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <?php
                    echo '<td> <input class="btn btn-danger" type="submit" name="delete" value="Delete"> </td>';
                    ?>
                </form>

            <?php
                //echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'> DELETE</a></td> ";


                echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
                echo "</tr>";
            }
            ?>


        </tbody>
    </table>
</form>

<?php
if (isset($_POST['delete'])) {
    $the_post = $_POST['post_id'];
    $query = "DELETE FROM posts WHERE post_id= {$the_post}";
    $delete_query = mysqli_query($connection, $query);
    confirm($delete_query);
    header("Location:posts.php");
}

if (isset($_GET['reset'])) {
    $the_post = $_GET['reset'];
    $query = "UPDATE posts SET post_views_count=0 WHERE post_id= {$the_post}";
    $reset_query = mysqli_query($connection, $query);
    confirm($reset_query);
    header("Location:posts.php");
}
?>


<script>
    $(document).ready(function() {
        $(".delete_link").on('click', function() {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete=" + id + " ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal("show");
        });
    });
</script>