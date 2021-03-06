<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Read</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="menu">
        <?php include 'header.php'; ?>
    </div>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Products</h1>
        </div>

        <style>
            .alnright {
                text-align: right;
            }
        </style>

        <?php
        // include database connection
        include 'config/database.php';

        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }


        $category = "";

        if ($_POST) {

            $category = htmlspecialchars(strip_tags($_POST['category']));

            if ($category == "A") {
                $query = "SELECT products.id as productid , products.name, category, price, promotion_price, manufacture_date, expired_date ,category.id,category.name as catname FROM products INNER JOIN category ON products.category = category.id ORDER BY products.id DESC";
            } else {
                $query = "SELECT products.id as productid , products.name, category, price, promotion_price, manufacture_date, expired_date ,category.id,category.name as catname FROM products INNER JOIN category ON products.category = category.id WHERE category = ? ORDER BY products.id DESC ";
            }
        } else {
            $query = "SELECT products.id as productid, products.name, category, price, promotion_price, manufacture_date, expired_date ,category.id,category.name as catname FROM products INNER JOIN category ON products.category = category.id ORDER BY products.id DESC";
        }

        $stmt = $con->prepare($query);
        if ($_POST && $category != "A") {
            $stmt->bindParam(1, $category);
        }
        $stmt->execute();
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='products_create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";
        ?>

        <?php
        $categoryquery = "SELECT id , name FROM category ORDER BY id DESC";
        $categorystmt = $con->prepare($categoryquery);
        $categorystmt->execute();

        $numcategory = $categorystmt->rowCount();

        if ($numcategory > 0) {

            echo "<form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>";
            echo "<select class='form-select' aria-label='Default select example' name='category'>";
            echo "<option value='A'>All</option>";
            while ($row = $categorystmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<option value=$id ";
                if ($id == $category) {
                    echo "selected";
                }
                echo ">";
                echo "{$name}";
                echo "</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Submit' class='btn btn-primary' />";
            echo "</form>";
        }
        ?>
        <?php
        //check if more than 0 record found
        if ($num > 0) {

            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Category</th>";
            echo "<th>Price</th>";
            echo "<th>Promotion Price</th>";
            echo "<th>Manufacture Date</th>";
            echo "<th>Expired Date</th>";
            echo "<th>Action</th>";
            echo "</tr>";


            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$productid}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$catname}</td>";
                echo "<td class = alnright>{$price}</td>";
                echo "<td class = alnright>{$promotion_price}</td>";
                echo "<td>{$manufacture_date}</td>";
                echo "<td>{$expired_date}</td>";
                echo "<td>";
                // read one record
                echo "<a href='products_read.php?id={$productid}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='products_update.php?id={$productid}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo '<a href="javascript: void(0)" onclick="delete_user('.$productid.');"  class="btn btn-danger">Delete</a>';
                echo "</td>";
                echo "</tr>";
            }


            // end table
            echo "</table>";
        }
        // if no records found
        else {
            echo "<div class='alert alert-danger'>No records found.</div>";
        }
        ?>


    </div> <!-- end .container -->

    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(id) {

            var answer = confirm('Are you sure?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'products_delete.php?id=' + id;
            }
        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>