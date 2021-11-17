<!DOCTYPE HTML>
<html>

<head>
    <title>Login</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <?php
        session_start();
        if ($_POST) {
            include 'config/database.php';

            $username = htmlspecialchars(strip_tags($_POST['username']));
            $password = htmlspecialchars(strip_tags($_POST['password']));

            if ($username == "" || $password == "") {
                echo "<div class='alert alert-danger row justify-content-center'>Please Enter Username and Password.</div>";
            }

            $query = "SELECT username, password, account_status FROM customers WHERE username =?";
            $stmt = $con->prepare($query);
            $stmt->bindParam(1, $username);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (is_array($row)) {
                if (md5($password) == $row['password']) {
                    if ($row['account_status'] == 1) {
                        $_SESSION["username"] = $username;
                        header("location: welcome.php");
                        exit;
                    } else {
                        echo "<div class='alert alert-danger row justify-content-center'>Not Active Account.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger row justify-content-center'>Wrong Password.</div>";
                }
            } else {
                echo "<div class='alert alert-danger row justify-content-center'>User Not Found.</div>";
            }
        }
        
        ?>


        <div class="d-flex justify-content-center text-center my-5 py-5">
            <div class="col-md-4 bg-light px-5 py-5 my-5">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <img class="mb-4" src="Logo.png" alt=login width="72" height="57">
                    <h1 class="h3 mb-3 fw-normal">Please Log In</h1>
                    <div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username">
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class=" form-floating">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>

                        <button class="w-100 btn btn-lg btn-primary my-5" type="submit">Sign in</button>
                        <p class="mt-5 mb-3 text-muted">© 2021</p>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>
</body>

</html>