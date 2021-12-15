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
            <h1>Create Category</h1>
        </div>
        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php


        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // posted values
                $catname = $_POST['name'];
                $flag = 1;
                $msg = "";

                if ($catname == "" ) {
                    $flag = 0;
                    $msg = "Please fill in all information. ";
                }

                $query = "SELECT name FROM category WHERE name =?";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $catname);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (is_array($row)) {
                    $flag = 0;
                    $msg  = $msg. "Category name already existed. Please use another name. ";
                }

                if ($flag == 1) {
                    // insert query
                    $query = "INSERT INTO category SET name=:name";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':name', $catname);

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
              
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='category_index.php' class='btn btn-danger'>Back to category details</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <?php include 'footer.php'; ?>
</body>

</html>