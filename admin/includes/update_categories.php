<form action="" method="POST">
    <div class="form-group">
        <label for="cat_title">Update Category</label>


        <?php

        if (isset($_GET['update'])) {
            $cat_id = $_GET['update'];
            $query = "SELECT * FROM categorias
                        WHERE cat_id=$cat_id";
            $select_categories = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_title = $row['cat_titulo'];
                $cat_id = $row['cat_id'];

        ?>
                <input value="<?php if (isset($cat_title)) {echo $cat_title;} ?>" class="form-control" type="text" name="cat_title">
        <?php }
        } ?>

        <?php //UPDATE QUERY
        if (isset($_POST['update_category'])) {
            $the_cat_title = $_POST['cat_title'];
            $stmt = mysqli_prepare($connection,"UPDATE categorias SET cat_titulo=? WHERE cat_id=?");
            mysqli_stmt_bind_param($stmt,'si',$the_cat_title,$cat_id);
            mysqli_stmt_execute($stmt);
            
            if (!$stmt) {
                die("Query failed" . mysqli_error($connection));
            }
            redirect("categories.php");
        }
        ?>

    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_category" value="Update">
    </div>
</form>