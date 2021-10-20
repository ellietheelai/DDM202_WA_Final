<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read One Record - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Read Customers</h1>
        </div>

        <!-- PHP read one record will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT customer_id, customer_name, birthdate FROM customers WHERE customer_id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $customer_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $customer_name = $row['customer_name'];
            $birthdate = $row['birthdate'];
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>



        <!-- HTML read one record table will be here -->
        <!--we have our html table here where the record will be displayed-->
        <table class='table table-hover table-responsive table-bordered'>
            <tr>
                <td>Customer Name</td>
                <td><?php echo htmlspecialchars($customer_name, ENT_QUOTES);  ?></td>
            </tr>
            <tr>
                <td>Birthdate</td>
                <td><?php echo date($birthdate, ENT_QUOTES);  ?></td>
            </tr>
            
            <tr>
                <td></td>
                <td>
                    <a href='customer_index.php' class='btn btn-danger'>Back to read customers</a>
                </td>
            </tr>
        </table>


    </div> <!-- end .container -->

</body>

</html>