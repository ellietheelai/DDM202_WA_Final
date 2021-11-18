<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- custom css -->
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
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $c_username = isset($_GET['username']) ? $_GET['username'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT username, password, first_name, last_name, gender, birthdate FROM customers WHERE username = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $c_username);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $password = $row['password'];
            $fname = $row['first_name'];
            $lname = $row['last_name'];
            $gender = $row['gender'];
            $dob = $row['birthdate'];


            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$c_username}</td>";
                echo "<td>{$password}</td>";
                echo "<td>{$fname}</td>";
                echo "<td>{$lname}</td>";
                echo "<td>{$gender}</td>";
                echo "<td>${$dob}</td>";
                echo "<td>";
                // read one record
                echo "<a href='read_one.php?username={$c_username}' class='btn btn-info m-r-1em'>Read</a>";

                // we will use this links on next part of this post
                echo "<a href='update.php?username={$c_username}' class='btn btn-primary m-r-1em'>Edit</a>";

                // we will use this links on next part of this post
                echo "<a href='#' onclick='delete_user({$c_username});'  class='btn btn-danger'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
        }

        // show error
        catch (PDOException $exception) {
            die('ERROR: ' . $exception->getMessage());
        }
        ?>

        <!-- HTML form to update record will be here -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?username={$c_username}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Password</td>
                    <td><input type='text' name='password' value="<?php echo htmlspecialchars($password, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>

                <tr>
                    <td>First Name</td>
                    <td><input type='text' name='first_name' value="<?php echo htmlspecialchars($fname, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>

                <tr>
                    <td>Last Name</td>
                    <td><input type='text' name='last_name' value="<?php echo htmlspecialchars($lname, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td> <input type="radio" id="female" name="gender" value="1 <?php echo htmlspecialchars($gender, ENT_QUOTES);  ?>">
                        <label for="female">Female</label>
                          <input type="radio" id="male" name="gender" value="0 <?php echo htmlspecialchars($gender, ENT_QUOTES);  ?>">
                        <label for="male">Male</label>
                    </td>
                     
                </tr>

                <tr>
                    <td>Date of Birth</td>
                    <td><input type='date' name='birthdate' value="<?php echo date($dob, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Save Changes' class='btn btn-primary' />
                        <a href='customer_index.php' class='btn btn-danger'>Back to read customers</a>
                    </td>
                </tr>
            </table>
        </form>

        <?php
        // check if form was submitted
        if ($_POST) {
            try {
                // write update query
                // in this case, it seemed like we have so many fields to pass and
                // it is better to label them and not use question marks
                $query = "UPDATE customers
                  SET password=:password, first_name=:first_name, last_name=:last_name, gender=:gender, birthdate=:birthdate WHERE username=:username";
                // prepare query for excecution
                $stmt = $con->prepare($query);
                // posted values
                $password = htmlspecialchars(strip_tags($_POST['password']));
                $fname = htmlspecialchars(strip_tags($_POST['first_name']));
                $lname = htmlspecialchars(strip_tags($_POST['last_name']));
                $gender = htmlspecialchars(strip_tags($_POST['gender']));
                $dob = date(strip_tags($_POST['birthdate']));
                // bind the parameters
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':first_name', $fname);
                $stmt->bindParam(':last_name', $lname);
                $stmt->bindParam(':gender', $gender);
                $stmt->bindParam(':birthdate', $dob);
                $stmt->bindParam(':username', $c_username);
                // Execute the query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Record was updated.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                }
            }
            // show errors
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        } ?>





    </div>
    <!-- end .container -->
</body>

</html>