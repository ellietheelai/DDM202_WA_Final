<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <?php include 'header.php';?>
    
    <div class="container">
        <div class="page-header">
            <h1>Read Orders Details</h1>
        </div>

        <!-- PHP code to read records will be here -->
        <?php
        // include database connection
        include 'config/database.php';

        // delete message prompt will be here

        $action = isset($_GET['action']) ? $_GET['action'] : "";

        // if it was redirected from delete.php
        if ($action == 'deleted') {
            echo "<div class='alert alert-success'>Record was deleted.</div>";
        }

        // select all data
        $query = "SELECT orderdetail_id, order_id, product_id, quantity, products.name as pname FROM orderdetails INNER JOIN products ON orderdetails.product_id = products.id ORDER BY orderdetail_id DESC";
      
        $stmt = $con->prepare($query);
        $stmt->execute();

        // this is how to get number of rows returned
        $num = $stmt->rowCount();

        // link to create record form
        echo "<a href='order_create.php' class='btn btn-primary m-b-1em mb-3'>Create New Order</a>";

        //check if more than 0 record found
        if ($num > 0) {

            // data from database will be here
            echo "<table class='table table-hover table-responsive table-bordered'>"; //start table

            //creating our table heading
            echo "<tr>";
            echo "<th>Order Detail ID</th>";
            echo "<th>Order ID</th>";
            echo "<th>Product ID</th>";
            echo "<th>Quantity</th>";
            echo "</tr>";

            // table body will be here
            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$orderdetail_id}</td>";
                echo "<td>{$order_id}</td>";
                echo "<td>{$pname}</td>";
                echo "<td>{$quantity}</td>";
                echo "<td>";
                // read one record
                echo "<a href='customer_read.php?orderdetail_id={$orderdetail_id}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='customer_update.php?orderdetail__id={$orderdetail_id}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a onclick='delete_user({$orderdetail_id});'  class='btn btn-danger'>Delete</a>";
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

    <!-- confirm delete record will be here -->
    <?php include 'footer.php'; ?>

    <script type='text/javascript'>
        // confirm record deletion
        function delete_user(orderdetail_id) {

            var answer = confirm('Are you sure?');
            if (answer) {
                // if user clicked ok,
                // pass the id to delete.php and execute the delete query
                window.location = 'customer_delete.php?orderdetail_id=' +  orderdetail_id;
            }
        }
    </script>
</body>

</html>