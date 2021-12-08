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
            <h1>Create Order</h1>
        </div>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post'>
            <?php
            include 'config/database.php';

            if ($_POST) {
                // include database connection
                echo "<pre>";
                var_dump($_POST);
                echo"</pre>";
                // posted values
                $customer = $_POST['customer'];
                $product_id = $_POST['product_id'];
                $quantity = $_POST['quantity'];

                // insert query
                $query = "INSERT INTO orders SET customer=:customer";
                // prepare query for execution
                $stmt = $con->prepare($query);

                // bind the parameters
                $stmt->bindParam(':customer', $customer);

                // Execute the query
                if ($stmt->execute()) {
                    $id = $con->lastInsertId();
                    echo "<div class='alert alert-success'>Record was saved. The Order ID is $id.</div>";

                    // insert query
                    $query = "INSERT INTO orderdetails SET quantity=:quantity, product_id=:product_id, order_id=:order_id";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
    
                    // bind the parameters
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':order_id', $id);
                    $stmt->execute();
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
                }
            }
            

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
            ?>
            <div class="row">
                <div class="col">

                    <?php
                    $productquery = "SELECT id, name FROM products ORDER BY id DESC";
                    $productstmt = $con->prepare($productquery);
                    $productstmt->execute();

                    $productnum = $productstmt->rowCount();

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
                <div class="col">
                    <select class='form-select' aria-label='Default select example' name='quantity[]'>
                        <option value='A'>Quantity</option>
                        <option value='1'>1</option>
                        <option value='2'>2</option>
                        <option value='3'>3</option>
                    </select>
            </div>
            
            <input type='submit' value='Submit' class='btn btn-primary' />
        </form>




    </div> <!-- end .container -->

    <?php include 'footer.php'; ?>
</body>

</html>