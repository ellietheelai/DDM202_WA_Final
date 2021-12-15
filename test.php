<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Order</title>
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
            <h1>Create Order</h1>
        </div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post'>
            <table class='table table-hover table-responsive table-bordered'>
                <?php
                include 'config/database.php';

                if ($_POST) {

                    // echo "<pre>";
                    // var_dump($_POST);
                    // echo "</pre>";

                    // posted values
                    $customer = $_POST['customer'];
                    $product_id = $_POST['product_id'];
                    $quantity = $_POST['quantity'];

                    // insert query
                    $query = "INSERT INTO orders SET customer=:customer";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':customer', $customer);
                    $stmt->execute();
                    $id = $con->lastInsertId();
                    echo "<div class='alert alert-success'>Record was saved. The Order ID is $id.</div>";

                    for ($y = 0; $y < count($product_id); $y++) {
                        // insert query
                        $query = "INSERT INTO orderdetails SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                        // prepare query for execution
                        $stmt = $con->prepare($query);

                        // bind the parameters
                        $stmt->bindParam(':order_id', $id);
                        $stmt->bindParam(':product_id', $product_id[$y]);
                        $stmt->bindParam(':quantity', $quantity[$y]);

                        // echo $product_id[$y]. "<br>";
                        // echo $quantity[$y]. "<br>"; 
                        // echo "<br>";

                        $stmt->execute();
                    }
                }

                echo "<tr>";
                echo "<td>Customer ID</td>";
                echo "<td>";
                $query = "SELECT first_name , last_name, username FROM customers ORDER BY username DESC";
                $stmt = $con->prepare($query);
                $stmt->execute();

                $num = $stmt->rowCount();

                if ($num > 0) {

                    echo "<select class='form-select' aria-label='Default select example' name='customer'>";
                    echo "<option value='A'>Username</option>";
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        echo "<option value=$username>$first_name $last_name";
                        echo "</option>";
                    }
                    echo "</select>";
                }
                echo "</td>";
                echo "</tr>";
                ?>

                <?php
                for ($x = 0; $x < 5; $x++) { ?>
                    <tr>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <?php
                                    $productquery = "SELECT id, name FROM products ORDER BY id DESC";
                                    $productstmt = $con->prepare($productquery);
                                    $productstmt->execute();
                                    $productnum = $productstmt->rowCount();

                                    //$stmt->bindParam(':quantity', $product_id[$orderQuantityA]);
                                    if ($productnum > 0) {

                                        echo "<select class= 'form-select' aria-label='Default select example' name='product_id[]'>";
                                        echo "<option value='A'>Product</option>";
                                        while ($row = $productstmt->fetch(PDO::FETCH_ASSOC)) {
                                            extract($row);
                                            echo "<option value=$id>$name";
                                            echo "</option>";
                                        }
                                        echo "</select>";
                                    }
                                    ?>
                                </div>
                        </td>
                        <td>
                            <div class="col">
                                <select class='form-select' aria-label='Default select example' name='quantity[]'>
                                    <option value='A'>Quantity</option>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                </select>
                            </div>
                        </td>

                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="2"><input type='submit' value='Submit' class='btn btn-primary'></td>
                </tr>
            </table>
        </form>
    </div>



    <?php include 'footer.php'; ?>
</body>

</html>