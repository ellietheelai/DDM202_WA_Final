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
            <h1>Create Customer</h1>
        </div>
        <!-- html form to create product will be here -->
        <!-- PHP insert code will be here -->
        <?php


        if ($_POST) {
            // include database connection
            include 'config/database.php';
            try {
                // posted values
                $username = $_POST['username'];
                $fname = $_POST['first_name'];
                $lname = $_POST['last_name'];
                $password = $_POST['password'];
                $cpassword = $_POST['confirm_password'];
                $gender = isset($_POST['gender']) ? $_POST['gender'] : "";
                $dob = $_POST['birthdate'];
                $mail = $_POST['email'];
                $flag = 1;
                $msg = "";
                $year = substr($dob, 0, 4);
                $todayyear = date("Y");
                $age = (int)$todayyear - (int)$year;

                if ($username == "" || $fname == "" || $lname == "" || $password == "" || $cpassword == "" || $gender == "" || $dob == "" || $mail == "") {
                    $flag = 0;
                    $msg = "Please fill in all information. ";
                }

                if (filter_var($mail, FILTER_VALIDATE_EMAIL) == false) {
                    $flag = 0;
                    $msg = $msg . "Email is not a valid email address. ";
                }

                if (strlen($password) < 6) {
                    $flag = 0;
                    $msg = $msg . "Password should be at least 6 characters in length. ";
                }
                if ($password != $cpassword) {
                    $flag = 0;
                    $msg = $msg . "Password does not match. ";
                }
                if ($age < 18) {
                    $flag = 0;
                    $msg = $msg . "User should be 18 years old or above. ";
                }

                $query = "SELECT username FROM customers WHERE username =?";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $username);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (is_array($row)) {
                    $flag = 0;
                    $msg  = $msg. "Username already existed. Please use another username. ";
                }

                $query = "SELECT email FROM customers WHERE username=?";
                $stmt = $con->prepare($query);
                $stmt->bindParam(1, $username);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if (is_array($row)) {
                    $flag = 0;
                    $msg  = $msg. "Email already existed. ";
                }

                if ($flag == 1) {
                    // insert query
                    $query = "INSERT INTO customers SET username=:username, first_name=:first_name, last_name=:last_name, birthdate=:birthdate, password=:password, gender=:gender, email=:email";
                    // prepare query for execution
                    $stmt = $con->prepare($query);

                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':first_name', $fname);
                    $stmt->bindParam(':last_name', $lname);
                    $epass = md5($password);
                    $stmt->bindParam(':password', $epass);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':birthdate', $dob);
                    $stmt->bindParam(':email', $mail);


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
                    <td>Username</td>
                    <td><input type='text' name='username' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><input type='text' name='email' class='form-control' /></td>
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
                        ?? <label for="female">Female</label>
                        ?? <input type="radio" id="male" name="gender" value="0">
                        ?? <label for="male">Male</label>
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
    <?php include 'footer.php'; ?>
</body>

</html>