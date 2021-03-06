<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php include 'config/database.php'; ?>
    <div class=" mt-5 d-flex justify-content-center">
        <!-- <h1>Welcome, </h1> -->
    </div>
    <div class="d-flex justify-content-center text-center">
    <?php
          
            echo "Today Date: ";
            echo date("M j, Y");
            echo "<br>";
            echo "Welcome";

            $id = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record user not found.');

            $query = "SELECT username, last_name, gender FROM customers WHERE username=?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $last_name = $row['last_name'];
            $gender = $row['gender'];

            if ($gender = 1) {
                echo " Ms ";
            } else {
                echo " Mr ";
            };
            echo $last_name;
          
            ?>
    </div>
   

    <div class=" mt-5 container">
        <div class="row">
            <div class="col">
                <div class="text-uppercase font-weight-bold text-center p-3 border bg-light">
                    <h3>Total Order</h3>
                    <?php $query = "SELECT * FROM orders ORDER BY order_id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();

                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();

                    if ($num > 0) {
                        echo $num;
                    } ?>
                </div>
            </div>
            <div class="col">
                <div class="text-uppercase font-weight-bold text-center p-3 border bg-light">
                    <h3>Total Product</h3>
                    <?php
                    // delete message prompt will be here
                    $action = isset($_GET['action']) ? $_GET['action'] : "";
                    // if it was redirected from delete.php
                    if ($action == 'deleted') {
                        echo "<div class='alert alert-success'>Record was deleted.</div>";
                    }

                    // select all data
                    $query = "SELECT id FROM products ORDER BY id DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();

                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();

                    if ($num > 0) {
                        echo $num;
                    }
                    ?>
                </div>
            </div>

            <div class="col">
                <div class="text-uppercase font-weight-bold text-center p-3 border bg-light">
                    <h3>Total Customer</h3>
                    <?php
                    // delete message prompt will be here
                    $action = isset($_GET['action']) ? $_GET['action'] : "";
                    // if it was redirected from delete.php
                    if ($action == 'deleted') {
                        echo "<div class='alert alert-success'>Record was deleted.</div>";
                    }

                    // select all data
                    $query = "SELECT username, email, first_name, last_name, gender, birthdate, registration_date_time, account_status FROM customers ORDER BY username DESC";
                    $stmt = $con->prepare($query);
                    $stmt->execute();

                    // this is how to get number of rows returned
                    $num = $stmt->rowCount();

                    if ($num > 0) {
                        echo $num;
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        $hsquery = "SELECT product_id, SUM(quantity) AS totalquantity, products.name as pname FROM orderdetails INNER JOIN products ON products.id = orderdetails.product_id GROUP BY product_id ORDER BY SUM(quantity) DESC LIMIT 3";
        $hsstmt = $con->prepare($hsquery);
        $hsstmt->execute();
        $hsnum = $hsstmt->rowCount();
        ?>

        <div class="container">
            <h3>Top 3 Selling Products</h3>

            <?php
            if ($hsnum > 0) {
                echo "<div class='row gx-1'>";
                echo "<div class='col text-center bg-light'>";
                echo "<td>1st</td>";
                echo "</br>";
                echo "<td>2nd</td>";
                echo "</br>";
                echo "<td>3rd</td>";
                echo "</br>";
                echo "</div>";
                echo "<div class='col text-center bg-light'>"; 

                while ($row = $hsstmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    echo "<div class='row row-cols-2'>";
                    echo "<div class='row'>";
                    echo "<div class='col'>";
                    echo "<div>$pname</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='row'>";
                    echo "<div class='col'>";
                    echo "<div>$totalquantity</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            }

            ?>
        </div>
        <div class=" mt-5 col">
            <div class=row-2>
                <div class="p-3 border bg-light">
                    <?php

                    $query = "SELECT order_id,customer,order_datetime FROM orders ORDER BY order_datetime DESC LIMIT 1";
                    $stmt = $con->prepare($query);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    // values to fill up our form
                    $order_id = $row['order_id'];
                    $customer = $row['customer'];
                    $order_datetime = $row['order_datetime'];

                    $query = "SELECT orderdetail_id, order_id, product_id, quantity, products.id, products.name as proname, products.price as proprice FROM orderdetails INNER JOIN products ON products.id = orderdetails.product_id WHERE order_id = ? LIMIT 1";
                    $stmt = $con->prepare($query);

                    // this is the first question mark
                    $stmt->bindParam(1, $oid);

                    // execute our query
                    $stmt->execute();
                    ?>
                    <table class=' table table-hover table-responsive table-bordered'>

                        <?php
                        $totalamount = 0;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                        ?>
                            <tr>
                                <td>Product</td>
                                <td><?php echo htmlspecialchars($proname, ENT_QUOTES); ?></td>
                                <td>Quantity</td>
                                <td><?php echo htmlspecialchars($quantity, ENT_QUOTES); ?></td>
                                <td>Price</td>
                                <td><?php echo htmlspecialchars($proprice, ENT_QUOTES); ?></td>
                                <td>Total</td>
                                <td><?php
                                    $total = ($proprice * $quantity);
                                    echo  number_format($total, 2);
                                    $totalamount = $totalamount + $total;
                                    ?></td>
                            </tr>
                        <?php
                        }
                        ?>

                        <div class="container px-4">
                            <div class="row gx-5">
                                <div class="col">
                                    <div class="p-3 bg-light">
                                        <h3>Latest Order</h3>
                                        <div class='col'>Order ID : <?php echo $order_id ?></div>
                                        <div class='col'>Customer Name : <?php echo $customer ?>
                                        </div>
                                        <div class='col'>Total Amount : <?php echo number_format($totalamount, 2); ?>
                                        </div>
                                        <div class='col'>Order Date : <?php echo $order_datetime ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>