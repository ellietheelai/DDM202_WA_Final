<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        include 'config/database.php';
        if ($_POST) {
            // include database connection

            try {
                // posted values
                $name = htmlspecialchars(strip_tags($_POST['name']));
                $description = htmlspecialchars(strip_tags($_POST['description']));
                $category = isset($_POST['category']) ? $_POST['category'] : "";
                $price = htmlspecialchars(strip_tags($_POST['price']));
                $p_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
                $m_date = date(strip_tags($_POST['manufacture_date']));
                $e_date = date(strip_tags($_POST['expired_date']));
                $flag = 1;
                $msg = "";
                $todaydate = date("Y-m-d");
                echo "category" . $category;

                if ($name == "" || $description == "" || $price == "" || $p_price == "" || $m_date == "" || $e_date == "" || $category == "") {
                    $flag = 0;
                    $msg = "Please fill in all information. ";
                }

                if (!is_numeric($price) && !is_numeric($p_price)) {
                    var_export($price && $p_price, true) . PHP_EOL;
                    $flag = 0;
                    $msg = $msg . "Please enter a number. ";
                }

                if ($p_price > $price) {
                    $flag = 0;
                    $msg = $msg . "Promotional price is more than normal price. ";
                }

                if ($m_date > $todaydate) {
                    $flag = 0;
                    $msg = $msg . "Manufacture date should not be greater than today's date. ";
                }

                if ($e_date < $m_date) {
                    $flag = 0;
                    $msg = $msg . "Expired date should be greater then manufacture date. ";
                }

                if ($flag == 1) {
                    // insert query
                    $query = "INSERT INTO products SET name=:name, description=:description, category=:category, price=:price, created=:created, promotion_price=:promotion_price, manufacture_date=:manufacture_date, expired_date=:expired_date";
                    // prepare query for execution
                    $stmt = $con->prepare($query);
                    // bind the parameters
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':description', $description);
                    $stmt->bindParam(':category', $category);
                    $stmt->bindParam(':price', $price);
                    $stmt->bindParam(':promotion_price', $p_price);
                    $stmt->bindParam(':manufacture_date', $m_date);
                    $stmt->bindParam(':expired_date', $e_date);
                    // specify when this record was inserted to the database
                    $created = date('Y-m-d H:i:s');
                    $stmt->bindParam(':created', $created);
                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>$msg</div>";
                }
            }

            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>


        <!-- html form here where the product information will be entered -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>
                        <?php
                        $categoryquery = "SELECT id , name FROM category ORDER BY id DESC";
                        $categorystmt = $con->prepare($categoryquery);
                        $categorystmt->execute();

                        $num = $categorystmt->rowCount();

                        if ($num > 0) {
                            echo "<select class= 'form-select' aria-label='Default select example' name='category'>";
                            echo "<option value='A'>Select a category</option>";
                            while ($categoryrow = $categorystmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($categoryrow);
                                echo "<option value=$id>$name";
                                echo "</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='text' name='promotion_price' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='products_index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <?php include 'footer.php'; ?>
</body>

</html>