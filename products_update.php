<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Update Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    
    
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>
</head>

<body>
    <div class="menu">
        <?php include 'header.php'; ?>
    </div>
    <div class="container">
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'Config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name, description, price, category, promotion_price,  manufacture_date, expired_date FROM products WHERE id = ?";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $id);

            // execute our query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $price = $row['price'];
            $category = $row['category'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>{$name}</td>";
                echo "<td>{$description}</td>";
                echo "<td>{$price}</td>";
                echo "<td>{$category}</td>";
                echo "<td>{$promotion_price}</td>";
                echo "<td>{$manufacture_date}</td>";
                echo "<td>{$expired_date}</td>";
                echo "<td>";
                echo "</td>";
                echo "</tr>";
            }
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>
        <?php
        // check if form was submitted
        if ($_POST) {   
            try {
             // posted values
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $description = htmlspecialchars(strip_tags($_POST['description']));
            $category = htmlspecialchars(strip_tags($_POST['category']));
            $price = htmlspecialchars(strip_tags($_POST['price']));
            $promotion_price = htmlspecialchars(strip_tags($_POST['promotion_price']));
            $manufacture_date = date(strip_tags($_POST['manufacture_date']));
            $expired_date = date(strip_tags($_POST['expired_date']));
            $todaydate = date("Y-m-d");

                if ($name == "" || $description == "" || $price == "" || $promotion_price == "" || $manufacture_date == "" || $expired_date == "" || $category == "") {
                    $flag = 0;
                    $msg = "Please fill in all information. ";
                }

                if (!is_numeric($price) && !is_numeric($promotion_price)) {
                    var_export($price && $promotion_price, true) . PHP_EOL;
                    $flag = 0;
                    $msg = $msg . "Please enter a number. ";
                }

                if ($promotion_price > $price) {
                    $flag = 0;
                    $msg = $msg . "Promotional price is more than normal price. ";
                }

                if ($manufacture_date > $todaydate) {
                    $flag = 0;
                    $msg = $msg . "Manufacture date should not be greater than today's date. ";
                }

                if ($expired_date < $manufacture_date) {
                    $flag = 0;
                    $msg = $msg . "Expired date should be greater then manufacture date. ";
                }

                if ($flag == 1){
                $query = "UPDATE products SET name=:name, description = :description, price =:price , promotion_price =:promotion_price, category= :category, manufacture_date = :manufacture_date ,expired_date =:expired_date WHERE id=:id";
                // prepare query for excecution
                $stmt = $con->prepare($query);
            
                // bind the parameters
                $stmt->bindParam(':expired_date', $expired_date);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':promotion_price', $promotion_price);
                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':manufacture_date', $manufacture_date);
                $stmt->bindParam(':expired_date', $expired_date);
                
                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }else {
                echo "<div class='alert alert-danger'>$msg</div>";
            }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } 
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Name</td>
                    <td><input type='text' name='name' value='<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><textarea name='description' class='form-control'><?php echo htmlspecialchars($description, ENT_QUOTES);  ?></textarea></td>
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
                                    echo "<option value=$id ";
                                    if($category == $id ) echo "selected";
                                    echo ">$name</option>";
                                }
                                echo "</select>";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><input type='text' name='price' value="<?php echo htmlspecialchars($price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                <tr>
                    <td>Promotion Price</td>
                    <td><input type='text' name='promotion_price' value="<?php echo htmlspecialchars($promotion_price, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                <tr>
                    <td>Manufacture Date</td>
                    <td><input type='date' name='manufacture_date' value="<?php echo date($manufacture_date, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                <tr>
                    <td>Expired Date</td>
                    <td><input type='date' name='expired_date' value="<?php echo $expired_date;  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='products_index.php' class='btn btn-danger'>Back to read products</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>