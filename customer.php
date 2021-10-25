<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Create Customer</h1>
        </div>
        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php
        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // insert query
                $query = "INSERT INTO customers SET username=:username, first_name=:first_name, last_name=:last_name, birthdate=:birthdate, password=:password, gender=:gender, registration_date_time=:registration_date_time";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // posted values
                $username= htmlspecialchars(strip_tags($_POST['username']));
                $fname = htmlspecialchars(strip_tags($_POST['first_name']));
                $lname = htmlspecialchars(strip_tags($_POST['last_name']));
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));

                // bind the parameters
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':first_name', $fname);
                $stmt->bindParam(':last_name', $lname);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':gender', $gender);

                // specify when this record was inserted to the database
                $dob = date('Y-m-d', strtotime($_POST['birthdate']));
                $r_datetime = date('Y-m-d H:i:s', strtotime($_POST['registration_date_time']));
                $stmt->bindParam(':birthdate', $dob);
                $stmt->bindParam(':registration_date_time', $r_datetime);
                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was saved.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to save record.</div>";
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
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type='password' name='password' class='form-control' /></td>
                </tr>

                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='first_name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='last_name' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td>  <input type="radio" id="female" name="gender" value="Female">
                          <label for="female">Female</label><br>
                          <input type="radio" id="male" name="gender" value="Male">
                          <label for="male">Male</label><br>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='birthdate' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Registration Date and Time</td>
                    <td><input type='date' name='registration_date_time' class='form-control' /></td>
                </tr>

                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save' class='btn btn-primary' />
                        <a href='customer_index.php' class='btn btn-danger'>Back to customer details</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <!-- end .container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>