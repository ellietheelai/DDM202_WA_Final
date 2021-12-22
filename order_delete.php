<?php include 'session.php'; ?>

<!DOCTYPE HTML>
<html>

<head>
    <title>PDO - Create a Record - PHP CRUD Tutorial</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

</html>

<?php
// include database connection
include 'config/database.php';
try {
    // get record ID
    // isset() is a PHP function used to verify if a value is there or not
    $oid = isset($_GET['order_id']) ? $_GET['order_id'] :  die('ERROR: Record ID not found.');

    // delete query
    $query = "DELETE FROM orderdetails WHERE order_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bindParam(1, $oid);

    if ($stmt->execute()) {
        $query = "DELETE FROM orders WHERE order_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $oid);

        if ($stmt->execute()) {
            header('Location: order_index.php?action=deleted');
        } else {
            die('Unable to delete record.');
        }

        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if ($action == 'deleted') {
            echo "<div class ='alert alert-success'>Record was deletd.</div>";
        }
    }else {
        die('Unable to delete record.');
    }
}
// show errors
catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>

<?php include 'footer.php'; ?>