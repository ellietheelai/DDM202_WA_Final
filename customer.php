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
                $query = "INSERT INTO customers SET username=:username, first_name=:first_name, last_name=:last_name, birthdate=:birthdate, password=:password, confirm_password=:confirm_password, gender=:gender";
                // prepare query for execution
                $stmt = $con->prepare($query);
                // posted values
                $username = htmlspecialchars(strip_tags($_POST['username']));
                $fname = htmlspecialchars(strip_tags($_POST['first_name']));
                $lname = htmlspecialchars(strip_tags($_POST['last_name']));
                $password = md5($_POST['password']);
                $cpassword = md5($_POST['confirm_password']);
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $dob = date('Y-m-d', strtotime($_POST['birthdate']));
                // bind the parameters
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':first_name', $fname);
                $stmt->bindParam(':last_name', $lname);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':confirm_password', $cpassword);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':birthdate', $dob);

                //if (strlen($password || $cpassword) < 6) {
                //    echo "<div class='alert alert-danger'>'Password should be at least 6 characters in length'.</div>";
                // } else {
                //     echo "<div class='alert alert-success'>'Strong Password'.</div>";
                // }

                if($_SERVER["REQUEST_METHOD"] == "POST"){

                $username = $password = $cpassword = "";
                $username_err = $password_err = $cpassword_err = "";

                // Validate password
                if (empty(trim($_POST["password"]))) {
                    $password_err = "Please enter a password.";
                } elseif (strlen(trim($_POST["password"])) < 6) {
                    $password_err = "Password must have atleast 6 characters.";
                } else {
                    $password = trim($_POST["password"]);

                    // Validate confirm password
                    if (empty(trim($_POST["confirm_password"]))) {
                        $cpassword_err = "Please confirm password.";
                    } else {
                        $cpassword = trim($_POST["confirm_password"]);
                        if (empty($password_err) && ($password != $cpassword)) {
                            $cpassword_err = "Password did not match.";
                        }
                    }

                    // Check input errors before inserting in database
                    if (empty($password_err) && empty($cpassword_err)) {

                        // Prepare an insert statement
                        $query= "INSERT INTO customers (username, first_name, last_name, birthdate, password, confirm_password, gender) VALUES ('$username', '$fname', '$lname', '$dob', '$password', '$cpassword', '$gender')";

                        if ($stmt = mysqli_prepare($db_name, $query)) {
                            // Bind variables to the prepared statement as parameters
                            mysqli_stmt_bind_param($stmt, "ss", $param_password);

                            // Set parameters
                            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                            // Attempt to execute the prepared statement
                            if (mysqli_stmt_execute($stmt)) {
                                // Redirect to login page
                                echo "Success";
                            } else {
                                echo "Oops! Something went wrong. Please try again later.";
                            }

                            // Close statement
                            mysqli_stmt_close($stmt);
                        }
                    }

                    // Close connection
                    mysqli_close($db_name);
                }
            }


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
                    <td><input type='password' name='password' class='form-control'></td>
                </tr>

                <tr>
                    <td>Confirm Password</td>
                    <td><input type='password' name='confirm_password' class='form-control'></td>
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
                    <td> <input type="radio" id="female" name="gender" value="1">
                          <label for="female">Female</label>
                          <input type="radio" id="male" name="gender" value="0">
                          <label for="male">Male</label>
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='birthdate' class='form-control' /></td>
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