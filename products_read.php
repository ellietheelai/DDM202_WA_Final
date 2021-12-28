<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Read Product</title>
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

        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $proid = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'Config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT products.id as productid , products.name, description, category, price, promotion_price, manufacture_date, expired_date ,category.id , category.name as catname FROM products INNER JOIN category ON                          products.category = category.id WHERE products.id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);
            
            // this is the first question mark
            $stmt->bindParam(1, $proid);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];
            $description = $row['description'];
            $catname = $row['catname'];
            $price = $row['price'];
            $promotion_price = $row['promotion_price'];
            $manufacture_date = $row['manufacture_date'];
            $expired_date = $row['expired_date'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>


        <!--we have our html table here where the record will be displayed-->
        <table class=' table table-hover table-responsive table-bordered'>
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Category</td>
                <td><?php echo htmlspecialchars($catname, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Description</td>
                <td><?php echo htmlspecialchars($description, ENT_QUOTES); ?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td>RM <?php echo number_format($price,2); ?></td>
            </tr>
            <tr>
                <td>Promotion Price</td>
                
                <td><?php if ($promotion_price != 0){
                    echo "RM";
                    echo number_format($promotion_price,2);
                    }else {
                        echo "-";
                    }  ?>
                </td>
            </tr>
            <tr>
                <td>Manufacture Time</td>
                <td><?php echo date($manufacture_date, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Expired Date</td>
                <td><?php echo date($expired_date, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href='products_index.php' class='btn btn-danger'>Back to read products</a>
                </td>
            </tr>
        </table>

    </div> <!-- end.container -->
    <?php include 'footer.php'; ?>
</body>

</html>