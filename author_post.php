<?php
include "includes/header.php";
include "includes/db.php";
?>


<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            if (isset($_GET['p_id'])) {
                $post_id = $_GET['p_id'];
                $the_post_user = $_GET['author'];
            }
            $query = "SELECT * FROM posts WHERE post_user='{$the_post_user}'";
            $select_all_posts_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
            ?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <?php echo $post_title ?>
                    </a>
                </h2>
                <p class="lead">
                    by
                    <?php 
                     $query="SELECT user_username FROM users WHERE user_id=$post_user";
                     $select_user=mysqli_query($connection,$query);
                    while($row=mysqli_fetch_array($select_user)){
                        $post_user=$row['user_username'];
                    }
                    echo $post_user ?>

                </p>
                <p>
                    <span class="glyphicon glyphicon-time"></span>
                    <?php echo $post_date ?>
                </p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="imagenes/<?php echo $post_image; ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
            <?php
            } ?>



            <?php
            if (isset($_POST['create_comment'])) {
                $the_post_id = $_GET['p_id'];
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];

                if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                    $query = "INSERT INTO comments(comment_post_id,
                    comment_author,
                    comment_email,
                    comment_content,
                    comment_status,
                    comment_date) 
                    VALUES($the_post_id,
                    '{$comment_author}'
                    ,'{$comment_email}'
                    ,'{$comment_content}'
                    ,'Unapproved'
                    ,now())";

                    $create_comment_query = mysqli_query($connection, $query);
                    //confirm($create_comment_query);
                    if (!$create_comment_query) {
                        echo "Query failed" . mysqli_error($connection);
                    }


                    $query = "UPDATE posts SET post_comments=post_comments+1 
                                WHERE post_id={$the_post_id}";
                    $update_comment_count = mysqli_query($connection, $query);
                    if (!$update_comment_count) {
                        echo "Query failed" . mysqli_error($connection);
                    }
                } else {
                    echo "<script> alert('Fields cannot be empty')</script>";
                }
            }
            ?>

            <hr>

            <!-- Posted Comments -->

            <!-- Comment -->




        </div>
        <?php
        include "includes/sidebar.php";
        ?>
    </div>
    <!-- /.row -->
    <hr>
    <?php
    include "includes/footer.php";
    ?>