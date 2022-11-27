<?php
session_start();
if(isset($_POST['deleteButton'])) {
    $_SESSION['accessedId'] = $_POST['deleteId'];
    if($_POST['deleteId']) {
        header('Location: ./delete.php');
    }
}
else if(isset($_POST['editButton'])) {
    $_SESSION['accessedId'] = $_POST['editId'];
    if($_POST['editId']) {
        echo $_SESSION['accessedId'];
        header("Location: ./update.php");
    }
}
?>