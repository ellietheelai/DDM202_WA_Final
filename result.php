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

                if (empty($password || $cpassword)) {
                    echo "Please enter password.";
                } elseif ($password != $cpassword) {
                    echo "Password does not match.";
                } elseif (strlen($password) < 6) {
                    echo "Password should be at least 6 characters in length";
                } else {

                    // bind the parameters
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':first_name', $fname);
                    $stmt->bindParam(':last_name', $lname);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':confirm_password', $cpassword);
                    $stmt->bindParam(':gender', $gender);
                    $stmt->bindParam(':birthdate', $dob);

                    // Execute the query
                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Record was saved.</div>";
                    } else {
                        echo "<div class='alert alert-danger'>Unable to save record.</div>";
                    }
                }
            }
            // show error
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }
        ?>