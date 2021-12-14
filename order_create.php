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
                    // include database connection
                    // echo "<pre>";
                    // var_dump($_POST);
                    // echo "</pre>";
                    /*
                $pp=$_POST['product_id'];
                $qq =$_POST['quantity'];

                echo $pp[0]."=".$qq[0]."<br>";
                echo $pp[1]."=".$qq[1]."<br>";
                echo $pp[2]."=".$qq[2]."<br>";
                */

                    // posted values
                    $customer = $_POST['customer'];
                    $product_id = $_POST['product_id'];
                    $quantity = $_POST['quantity'];
                    $insert = 0;

                    // insert query
                    $query = "INSERT INTO orders SET customer=:customer";
                    $stmt = $con->prepare($query);

                    $stmt->bindParam(':customer', $customer);
                    $stmt->execute();
                    $id = $con->lastInsertId();
                    echo "<div class='alert alert-success'>Record was saved. The Order ID is $id.</div>";
                    
                    while ($insert < 3) {
                        if ($stmt->execute()) {
                            // insert query
                            $query = "INSERT INTO orderdetails SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                            // prepare query for execution
                            $stmt = $con->prepare($query);

                            // bind the parameters
                            $stmt->bindParam(':order_id', $id);
                            $stmt->bindParam(':product_id', $product_id[$insert]);
                            $stmt->bindParam(':quantity', $quantity[$insert]);

                            echo $product_id[$insert] . "<br>";
                            echo $quantity[$insert];

                            $stmt->execute();
                        } else {
                            echo "<div class='alert alert-danger'>Unable to save record.</div>";
                        }
                        $insert++; //+1
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

                <tr>
                    <td>Products</td>
                    <td>
                        <div class="row">
                            <div class="col">
                                <?php
                                $orderQuantityA = 0;
                                $orderQuantityB = 0;
                                $productquery = "SELECT id, name FROM products ORDER BY id DESC";
                                $productstmt = $con->prepare($productquery);


                                while ($orderQuantityA < 3) {

                                    $orderQuantityA++; //+1
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
                                }
                                ?>
                            </div>
                    </td>
                </tr>

                <tr>
                    <td>Products</td>
                    <td>
                        <div class="col">
                            <?php
                            while ($orderQuantityB < 3) {
                                $orderQuantityB++;
                                echo "<select class='form-select' aria-label='Default select example' name='quantity[]'>
                                        <option value='A'>Quantity</option>
                                        <option value='1'>1</option>
                                        <option value='2'>2</option>
                                        <option value='3'>3</option>
                                    </select>";
                            }
                            ?>
                        </div>
                    </td>
                </tr>
    </div>
    </form>
    </table>
    <td><input type='submit' value='Submit' class='btn btn-primary' /></td>

    <?php include 'footer.php'; ?>
</body>

</html>