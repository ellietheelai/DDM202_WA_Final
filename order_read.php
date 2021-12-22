<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Read One</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="menu">
        <?php include 'header.php'; ?>
    </div>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Product</h1>
        </div>

        <style>
            .alnright {
                text-align: right;
            }
        </style>

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $oid = isset($_GET['order_id']) ? $_GET['order_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT orderdetail_id, order_id, product_id, quantity, products.id, products.name as proname, products.price as proprice FROM orderdetails INNER JOIN products ON products.id = orderdetails.product_id WHERE order_id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $oid);

            // execute our query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $order_id = $row['order_id'];
        ?>
            <table class=' table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Order ID</td>
                    <td colespan="8"><?php echo htmlspecialchars($order_id, ENT_QUOTES); ?></td>
                </tr>
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
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
            ?>
            <tr>
                <td>Total Amount</td>
                <td class = alnright colspan="8"><?php echo number_format($totalamount, 2) ?></td>

            </tr>
            <tr>
                <td colspan="8">
                    <a href='order_index.php' class='btn btn-danger'>Back to read orders</a>
                </td>
            </tr>
            </table>
    </div> <!-- end.container -->
    <?php include 'footer.php'; ?>
</body>

</html>