<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="POST">
            <div class="input-group">
                <input type="text" class="form-control" name="search">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <div class="well">

        <?php if (isset($_SESSION['user_role'])) : ?>
            <h4>Loged in as <?php echo $_SESSION['username']; ?> </h4>
            <a href="includes/logout.php" class="btn btn-primary">Logout</a>
        <?php else : ?>
            <h4>Login</h4>
            <form action="includes/login.php" method="POST">
                <div class="form-group">
                    <input type="input" class="form-control" name="username" placeholder="Enter username">
                </div>
                <div class="input-group">
                    <input type="password" class="form-control" name="password" placeholder="Enter password">
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit
                        </button>
                    </span>
                </div>
            </form>
        <?php endif; ?>


        <!-- /.input-group -->
    </div>

    <!-- Blog Categories Well -->
    <div class="well">

        <?php
        $query = "SELECT * FROM categorias";
        $select_categories_sidebar = mysqli_query($connection, $query);

        ?>
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_title = $row['cat_titulo'];
                        $cat_id = $row['cat_id'];
                        echo "<li>  <a href='category.php?category=$cat_id'> {$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->

            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php
    include "widget.php";
    ?>


</div>