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
    <?php include 'header.php'; ?>
    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Update Customer</h1>
        </div>
        <!-- PHP read record by ID will be here -->
        <?php
        // get passed parameter value, in this case, the record ID
        // isset() is a PHP function used to verify if a value is there or not
        $cat_id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

        //include database connection
        include 'config/database.php';

        // read current record's data
        try {
            // prepare select query
            $query = "SELECT id, name FROM category WHERE id = ? LIMIT 0,1";
            $stmt = $con->prepare($query);

            // this is the first question mark
            $stmt->bindParam(1, $cat_id);

            // execute our query
            $stmt->execute();

            // store retrieved row to a variable
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // values to fill up our form
            $name = $row['name'];

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['firstname'] to just $firstname only
                extract($row);
                // creating new table row per record
                echo "<tr>";
                echo "<td>{$id}</td>";
                echo "<td>${$name}</td>";
                echo "<td>";
                // read one record
                echo "<a href='read_one.php?username={$id}' class='btn btn-info m-r-1em'>Read</a>";

                echo "<a href='c_update.php?username={$id}' class='btn btn-primary m-r-1em'>Edit</a>";

                echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Delete</a>";
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
        if ($_POST) {

            $password = htmlspecialchars(strip_tags($_POST['password']));
            $fname = htmlspecialchars(strip_tags($_POST['first_name']));
            $lname = htmlspecialchars(strip_tags($_POST['last_name']));
            $gender = htmlspecialchars(strip_tags($_POST['gender']));
            $dob = date(strip_tags($_POST['birthdate']));
            $npassword = $_POST['new_password'];
            $n_cpassword = $_POST['new_confirm_password'];
            $mail = $_POST['email'];
            $year = substr($dob, 0, 4);
            $todayyear = date("Y");
            $age = (int)$todayyear - (int)$year;
            // // $msg = "";
            $flag = 1;

            if ($fname == "" || $lname == "" || $gender == "" || $dob == "" || $mail == "") {
                $flag = 0;
                echo "<div class='alert alert-danger'>Please fill in all information. </div>";
            }

            if (filter_var($mail, FILTER_VALIDATE_EMAIL) == false) {
                $flag = 0;
                echo  "<div class='alert alert-danger'>Email is not a valid email address.</div> ";
            }

            if ($age < 18) {
                $flag = 0;
                echo "<div class='alert alert-danger'>User should be 18 years old or above.</div> ";
            }

            $query = "SELECT email FROM customers WHERE email= ?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $mail);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (is_array($row)) {
                    $flag = 0;
                    echo  "<div class='alert alert-danger'>Email already existed.</div> ";
            }

            if ($password == "" && $npassword == "" && $n_cpassword == "") {
                if ($flag == 1) {
                    $query = "UPDATE customers SET first_name=:first_name, last_name=:last_name, gender=:gender, birthdate=:birthdate, email=:email WHERE username=:username";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(':username', $c_username);
                    $stmt->bindParam(':first_name', $fname);
                    $stmt->bindParam(':last_name', $lname);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':birthdate', $dob);
                    $stmt->bindParam(':email', $mail);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was updated.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                    }
                }

                echo "Not changing password";
            } else {

                if ($password == "" || $npassword == "" || $n_cpassword == "") {
                    $flag = 0;
                    echo "Please fill in fields. ";
                }

                if (strlen($password) < 6 || strlen($npassword) < 6 || strlen($n_cpassword) < 6) {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>Password should be at least 6 characters in length. </div>";
                }

                if ($npassword !== $n_cpassword) {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>New password does not match .</div>";
                }

                if ($npassword == $password) {
                    $flag = 0;
                    echo "<div class='alert alert-danger'>New password cannot be the same as the current password. </div>";
                }

                if ($flag == 1) {
                    $query = "SELECT username, password FROM customers WHERE username = ? LIMIT 0,1";
                    $stmt = $con->prepare($query);
                    $stmt->bindParam(1, $c_username);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if (is_array($row)) {
                        if (md5($password) !== $row['password']) {
                            echo "<div class='alert alert-danger'>Wrong Password.</div>";
                        } else {
                            $query = "UPDATE customers SET password=:password ,first_name=:first_name, last_name=:last_name, gender=:gender, birthdate=:birthdate, email=:email WHERE username=:username";
                            $stmt = $con->prepare($query);
                            $epass = md5($npassword);
                            $stmt->bindParam(':password', $epass);
                            $stmt->bindParam(':username', $c_username);
                            $stmt->bindParam(':first_name', $fname);
                            $stmt->bindParam(':last_name', $lname);
                            $stmt->bindParam(':gender', $gender);
                            $stmt->bindParam(':birthdate', $dob);
                            $stmt->bindParam(':email', $mail);


                            if ($stmt->execute()) {
                                echo "<div class='alert alert-success'>Record was updated.</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                            }
                        }
                    }
                }
            }
        }


        // if ($password == "" || $npassword == "" || $n_cpassword == ""){
        //     $flag = 0;
        //     echo "<div class='alert alert-danger'>Please fill in all information. </div>";
        // }


        //     $flag = 0;
        //     echo "<div class='alert alert-danger'>User should be 18 years old or above.</div> ";
        // }

        // if ($npassword == $n_cpassword) {
        //     $query = "UPDATE customers SET password='$npassword' where username=:username";
        // } else {
        //     echo "Unsucessful attempt";
        // }




        //             if ($flag == 1) {
        //                 // write update query
        //                 // in this case, it seemed like we have so many fields to pass and
        //                 // it is better to label them and not use question marks
        //                 $query = "UPDATE customers
        //             SET first_name=:first_name, last_name=:last_name, gender=:gender, birthdate=:birthdate WHERE username=:username";
        //                 // prepare query for excecution
        //                 $stmt = $con->prepare($query);

        //                 // bind the parameters
        //                 $stmt->bindParam(':first_name', $fname);
        //                 $stmt->bindParam(':last_name', $lname);
        //                 $stmt->bindParam(':gender', $gender);
        //                 $stmt->bindParam(':birthdate', $dob);
        //                 $stmt->bindParam(':username', $c_username);

        //                 

        //         } else {
        //              // write update query
        //                 // in this case, it seemed like we have so many fields to pass and
        // it is better to label them and not use question marks

        //     }
        // }
        //     // show errors
        //     catch (PDOException $exception) {
        //         die('ERROR: ' . $exception->getMessage());
        //     }
        // }
        ?>

        <!-- HTML form to update record will be here -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?username={$c_username}"); ?>" method="post">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Username</td>
                    <td><?php echo htmlspecialchars($c_username, ENT_QUOTES);  ?></td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td><input type='text' name='email' value="<?php echo htmlspecialchars($mail, ENT_QUOTES);  ?>" class='form-control' /></td>
                </tr>
                <tr>

                <tr>
                    <td>Current Password</td>
                    <td><input type='password' name='password' value="" class='form-control' /></td>
                </tr>

                <tr>
                    <td>New Password</td>
                    <td><input type='password' name='new_password' value="" class='form-control' /></td>
                </tr>

                <tr>
                    <td>Confirm New Password</td>
                    <td><input type='password' name='new_confirm_password' value="" class='form-control' /></td>
                </tr>

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
                    <td> <input type="radio" id="female" name="gender" value="1" <?php if (isset($gender) && $gender == "1") echo "checked" ?>>

                        <label for="female">Female</label>
                          <input type="radio" id="male" name="gender" value="0" <?php if (isset($gender) && $gender == "0") echo "checked" ?>>

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




    </div>
    <!-- end .container -->
</body>

</html>