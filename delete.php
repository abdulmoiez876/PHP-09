<?php
session_start();
include './config.php';
if (isset($_SESSION['accessedId'])) {
    $deleteId = (int)$_SESSION['accessedId'];
    echo $deleteId;

    $queryForPicPath = "SELECT picPath FROM employees WHERE employeeNumber=$deleteId";
    $execForPicPath = mysqli_query($connection, $queryForPicPath);

    $resultForPicPath = mysqli_fetch_assoc($execForPicPath)['picPath'];

    $resultText = '';

    if($resultForPicPath) {
        unlink('./assets/'.$resultForPicPath);
        $resultText.='Image Deleted and ';
    }

    $query = "SET FOREIGN_KEY_CHECKS=0; ";
    $query .= "DELETE FROM employees WHERE employeeNumber = $deleteId";

    $exec = mysqli_multi_query($connection, $query);
    if ($exec) {
        $resultText.= "cleared from database";
    } else {
        $resultText.= "Failed to delete from database";
    }
    echo $resultText;

    session_unset();
    session_destroy();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>

<body>
    <br>
    <a href="./lab9.php">Go Back</a>
</body>

</html>